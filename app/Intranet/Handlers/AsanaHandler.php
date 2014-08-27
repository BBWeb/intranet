<?php namespace Intranet\Handlers;

use Intranet\Api\AsanaApi;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

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
            // cache in redis for set time
         $this->redis->set('tasks:' . $task->id, serialize( $taskData ));
         $this->redis->sadd('users:' . $this->user->id, $task->id);

         // add to users set
      }
      // go through all assigned tasks and update for user

      // get lists of tasks for asana

         // more info about them

      // insert each and every one of them
   }

   public function getUserTasks()
   {
      // get the id
      $userTasks = $this->redis->smembers('users:' . $this->user->id);

      $resArray = $this->redis->pipeline(function($pipe) use (&$userTasks) {
         foreach ($userTasks as $taskId) {
            $pipe->get('tasks:' . $taskId);
         }
      });

      $tasks = [];

      foreach($resArray as $val) {
         array_push($tasks, unserialize( $val ));
      }
      // get all of the members

      // pipeline a get
      return $tasks;
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

      if ( $responseCode != '200' ) return;

      foreach ( $tasks->data as $key => $task ) {

         // if the tasks is found already, remove it etc
         $existingTask = $this->user->tasks()->where('asana_id', '=', $task->id)->first();

         if ( $existingTask ) {
            // have the name been changed?
            if ( $existingTask->task != $task->name ) {
               // update the task in our db
               $existingTask->task = $task->name;
               $existingTask->save();
            }

            unset($tasks->data[$key]);
            continue;
         }

         // if exists in redis?
         if ( Cache::has( $task->id ) ) {
            $cachedTaskState = unserialize( Cache::get( $task->id ) );
            $task->taskState = $cachedTaskState;
         } else {
            // get additional info about the tasks (extra HTTP req)
            $taskState = $asana->getOneTask( $task->id );
            $task->taskState = $taskState;
            // cache in redis for set time
            Cache::put( $task->id, serialize( $taskState ), self::CACHE_TIME );
         }

      }

      return $tasks;
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
}

