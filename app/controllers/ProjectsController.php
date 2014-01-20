<?php

use Intranet\Handlers\AsanaHandler;

class ProjectsController extends BaseController {

   public function getIndex()
   {
      $user = Auth::user();

      if ( $user->api_key == '' ) return Redirect::to('account');

			$asanaHandler = new AsanaHandler( $user->api_key );
    	$projects = $asanaHandler->getProjects();

			return View::make('user.start')->with('projects', $projects);
   }
}

