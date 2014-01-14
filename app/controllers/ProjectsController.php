<?php

use Intranet\Handlers\AsanaHandler;

class ProjectsController extends BaseController {

   public function getIndex()
   {
		$asanaHandler = new AsanaHandler();
      $projects = $asanaHandler->getProjects();

		return View::make('user.start')->with('projects', $projects);
   }
}

