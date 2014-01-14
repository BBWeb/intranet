<?php namespace Intranet\Handlers;

use Intranet\Api\AsanaApi;

class AsanaHandler {
   
   // B&B Web WorkspaceID (hardcoded for now)
   const WORKSPACE_ID = '5021327445263';

   private $apiKey;

   public function __construct($apiKey)
   {
      $this->apiKey = $apiKey;
   }

   public function getProjects() 
   {
      $asana = new AsanaApi( $this->apiKey );

      $projects = $asana->getProjects( self::WORKSPACE_ID );
      return $projects;
   }

   public function getProjectTasks($project)
   {
      $asana = new AsanaApi( $this->apiKey );

      $userId = $asana->getUserId();
      $tasks = json_decode( $asana->getTasks( self::WORKSPACE_ID ) );

      $responseCode = $asana->getResponseCode();
      if ( $responseCode != '200' ) return; 

      foreach ( $tasks->data as $task ) {
         $taskState = $asana->getOneTask( $task->id );
         $task->taskState = $taskState;
      }

      return $tasks;
   }
}

