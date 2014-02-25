<?php namespace Intranet\Handlers;

use Intranet\Api\AsanaApi;
use Illuminate\Support\Facades\Redis;

class AsanaHandler {

   // B&B Web WorkspaceID (hardcoded for now)
   const WORKSPACE_ID = '5021327445263';
   // Ten days cache time
   const CACHE_TIME = 864000;

   private $user;
   private $apiKey;
   private $redis;

   public function __construct($user)
   {
      $this->user = $user;
      $this->apiKey = $user->api_key;
      $this->redis = Redis::connection();
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
         if ( $this->user->tasks()->where('asana_id', '=', $task->id)->first() ) {
            unset($tasks->data[$key]);
            continue;
         }

         // if exists in redis?
         $cachedTaskState = $this->redis->get( $task->id );
         if ($cachedTaskState) {
            $task->taskState = unserialize( $cachedTaskState );
         } else {
            $taskState = $asana->getOneTask( $task->id );
            $task->taskState = $taskState;

            // cache in redis for the set time
            $this->redis->set( $task->id, serialize( $taskState ), self::CACHE_TIME );
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

