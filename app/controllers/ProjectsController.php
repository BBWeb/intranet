<?php

use Intranet\Handlers\AsanaHandler;

class ProjectsController extends BaseController {

   public function getIndex()
   {
      $user = Auth::user();

      // $asanaHandler = new AsanaHandler( $user->api_key );
      //	$projects = $asanaHandler->getProjects();
      $tasks = $user->tasks()->whereStatus('notreported')->get();

      return View::make('user.start')->with('tasks', $tasks);
   }
}

