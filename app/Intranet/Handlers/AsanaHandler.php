<?php namespace Intranet\Handlers;

use Intranet\Api\AsanaApi;

class AsanaHandler {
   
   // B&B Web WorkspaceID (hardcoded for now)
   const WORKSPACE_ID = '5021327445263';

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

      // get all added tasks for the current user
      //    $user->tasks()->whereAsanaId('')
      // if the task is already added to the db, skip request
      foreach ( $tasks->data as $key => $task ) {
         // if the tasks is found already, remove it etc
         if ( $this->user->tasks()->where('asana_id', '=', $task->id)->first() ) {
            unset($tasks->data[$key]);
            continue;
         }
         $taskState = $asana->getOneTask( $task->id );
         $task->taskState = $taskState;
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

