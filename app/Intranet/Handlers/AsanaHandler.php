<?php namespace Intranet\Handlers;

use Intranet\Api\AsanaApi;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;

use \DateTime;
use \DateInterval;
use \AsanaTask;
use \Project;
use \LastQueryCache;

class AsanaHandler {

   // B&B Web WorkspaceID (hardcoded for now)
   const WORKSPACE_ID = '5021327445263';
   // Ten days cache time (minutes)
   const CACHE_TIME = 14400;

   private $user;
   private $apiKey;
   private $redis;

   public function __construct($user)
   {
      $this->user = $user;
      $this->apiKey = $user->api_key;

      $this->redis = Redis::connection();
   }

   public function updateAllTasks()
   {
      $asana = new AsanaApi( $this->apiKey );

      $tasks = json_decode( $asana->getTasks( self::WORKSPACE_ID ) );

      $responseCode = $asana->getResponseCode();

      if ( $responseCode != '200' ) return;

      foreach ($tasks->data as $key => $task) {
         $taskData = $asana->getOneTask( $task->id );

         // if completed remove
         if ( $taskData['completed'] ) {
            continue;
         }

         // if project does not exist, create it
         $projectData = $taskData['projects'];

         $project = $this->findOrCreateProject( $projectData );

         $asanaTask = AsanaTask::find($task->id);

         if (!$asanaTask) {
            AsanaTask::create([
               'id' => $task->id,
               'project_id' => $project->id,
               'name' => $taskData['name'],
               'completed' => false,
               'user_id' => $this->user->id
            ]);
         }

      }

      $this->saveQueryTime();
   }

   public function updateTasksSinceLastQuery()
   {
      $asana = new AsanaApi( $this->apiKey );

      $lastQueryTime = $this->getLastQueryTime();

      $modifiedTasks = json_decode( $asana->getModifiedTasks( self::WORKSPACE_ID, $lastQueryTime ) );

      Log::info("Modified tasks");
      Log::info(print_r($modifiedTasks, true));

      if (!array_key_exists('data', $modifiedTasks) || empty($modifiedTasks->data)) return;

      foreach ($modifiedTasks->data as $key => $task)
      {
         $taskData = $asana->getOneTask( $task->id );

         $this->updateOrCreateAsanaTask($task->id, $taskData);
      }

      $this->saveQueryTime();
   }

   public function getProjects()
   {
      $asana = new AsanaApi( $this->apiKey );

      $projects = $asana->getProjects( self::WORKSPACE_ID );
      return $projects;
   }

   public function getAllAssignedTasks()
   {
      $asana = new AsanaApi( $this->apiKey );

      $tasks = json_decode( $asana->getTasks( self::WORKSPACE_ID ) );

      $responseCode = $asana->getResponseCode();

      if ( $responseCode != '200' ) return [];

      return $tasks->data;
   }

   public function getProjectTasks($projectId)
   {
      $asana = new AsanaApi( $this->apiKey );

      $tasks = json_decode( $asana->getProjectTasks( $projectId ) );

      $responseCode = $asana->getResponseCode();

      if ( $responseCode != '200' ) return;

      foreach ( $tasks->data as $task ) {
         // is the task already added to our db?
         // Skip it
         $taskState = $asana->getOneTask( $task->id );
         $task->taskState = $taskState;
      }

      return $tasks;
   }

   public static function deleteNotFoundTasks($key, $taskIds)
   {
      $asana = new AsanaApi( $key );

      // go through all of the tasks ids
      foreach ($taskIds as $id)
      {
         // check the state in asana
         $taskResponse = $asana->checkTaskExistance( $id );

         // if a task is not found on asana a 404 error should be returned
         if ( $asana->getResponseCode() != 404) continue;

         $asanaTask = AsanaTask::find( $id );

         $nrTasks = $asanaTask->tasks()->count();

         // if we have tasks connected to the Asana task,
         // complete it
         if ( $nrTasks > 0 )
         {
            $asanaTask->completed = true;
            $asanaTask->completion_date = date('Y-m-d'); // TODO extract to some util library as its used all over the app
            $asanaTask->update();
         } else {
            // otherwise delete it
            $asanaTask->delete();
         }
      }
   }

   private function getLastQueryTime()
   {
      $lastQueryCache = DB::table('lastquery_cache')->where('user_id', $this->user->id)->first();

      if ($lastQueryCache) {
         return $lastQueryCache->time;
      }
      else
      {
         $queryTime = new DateTime();
         $queryTime->sub(new DateInterval('PT1H'));

         return $queryTime->format(DateTime::ISO8601);
      }
   }

   private function saveQueryTime()
   {
      $currentDateTime = new DateTime();

      $lastQueryCache = LastQueryCache::firstOrCreate([
         'user_id' => $this->user->id
      ]);

      $lastQueryCache->time = $currentDateTime->format(DateTime::ISO8601);

      $lastQueryCache->update();
   }

   private function updateOrCreateAsanaTask($taskId, $taskData)
   {
      // project should exist, otherwise create it
      $projectData = $taskData['projects'];
      $project = $this->findOrCreateProject( $projectData );

      $asanaTask = AsanaTask::find($taskId);

      // update an existing
      if ($asanaTask)
      {
         // if the task was completed and now unchecked, do nothing
         if ( $asanaTask->completed && !$taskData['completed'] ) return;

         if ( $taskData['completed'] ) {
            $asanaTask->completion_date = $this->getCurrentDate();
         }

         $asanaTask->name = $taskData['name'];
         $asanaTask->completed = $taskData['completed'];
         $asanaTask->project_id = $project->id;
         $asanaTask->user_id = $this->user->id;
         $asanaTask->update();
      }
      else
      {
         $completionDate = $taskData['completed'] ? $this->getCurrentDate() : '0000-00-00';

         AsanaTask::create([
            'id' => $taskId,
            'project_id' => $project->id,
            'name' => $taskData['name'],
            'completed' => $taskData['completed'],
            'completion_date' => $completionDate,
            'user_id' => $this->user->id
         ]);
      }
   }

   private function getCurrentDate()
   {
      return date('Y-m-d');
   }

   private function findOrCreateProject($projectData)
   {
      $project = Project::find( $projectData['id'] );

      if ( !$project ) {
         $project = Project::create(array(
            'id' => $projectData['id'],
            'name' => $projectData['name']
         ));
      }

      return $project;
   }
}

