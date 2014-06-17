<?php

use Intranet\Handlers\AsanaHandler;

class ProjectsController extends BaseController {

   public function getIndex()
   {
      $user = Auth::user();

      $tasks = $user->notreportedTasks;

      return View::make('user.start')->with('tasks', $tasks);
   }
}

