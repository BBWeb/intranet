<?php namespace Intranet\Handlers;

use Intranet\Api\AsanaApi;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AsanaHandler {

   // B&B Web WorkspaceID (hardcoded for now)
   const WORKSPACE_ID = '5021327445263';
   // Ten days cache time (minutes)
   const CACHE_TIME = 14400;

   private $user;
   private $apiKey;

   public function __construct($user)
   {
      $this->user = $user;
      $this->apiKey = $user->api_key;
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

