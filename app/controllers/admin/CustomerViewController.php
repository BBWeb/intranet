<?php

class CustomerViewController extends BaseController {

	public function getIndex()
	{
		$user = Auth::user();

	     if ( $user->api_key == '' ) return Redirect::to('account');

	    // $asanaHandler = new AsanaHandler( $user->api_key );
	    //	$projects = $asanaHandler->getProjects();
	    $projects = DB::table('tasks')->select('project')->distinct()->get();

	    return View::make("admin.customer-report")->with('projects', $projects);
	}

}
