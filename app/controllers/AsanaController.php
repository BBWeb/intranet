<?php

use Intranet\Handlers\AsanaHandler;

class AsanaController extends BaseController {

   public function show($projectId)
   {
      $user = Auth::user();
      $asana = new AsanaHandler( $user );

      $projectTasks;

      if ( $projectId == 'all' ) {
         $projectTasks = $asana->getAllAssignedTasks();
      } else {
         $projectTasks = $asana->getProjectTasks( $projectId );
      }

      return Response::json( $projectTasks );
   }

   public function postTriggerAsanaUpdate()
   {
      // trigger a new update

      // return all tasks
   }
}
