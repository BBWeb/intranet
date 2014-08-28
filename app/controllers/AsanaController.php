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
      $user = Auth::user();
      $asana = new AsanaHandler( $user );

      $asanaTasks = $asana->updateTasksSinceLastQuery();

      return Response::json([
         'template' => View::renderEach('templates.asana_task', $asanaTasks, 'asanaTask')
      ]);
   }
}
