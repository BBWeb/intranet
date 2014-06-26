<?php

class ChangesController extends \BaseController {

	public function getIndex()
	{
		$projects = Project::lists('name', 'id');
		// we want a list of projects
		return \View::make('admin.changes.base', array(
			'projects' => $projects
			)
		);	
	}	

	public function postIndex()
	{
		// get project	

		// construct a route
	}
}