<?php

class CustomerViewController extends BaseController {

	public function getIndex()
	{
	    $projects = DB::table('tasks')->select('project')->distinct()->get();

	    return View::make('admin.customer-report.base')->with('projects', $projects);
	}

	public function getProjectOverview($project, $from, $to)
	{
	    $projects = DB::table('tasks')->select('project')->distinct()->get();

	    // get all the tasks for the project, reported between $from and $to?
	    $projectTasks = DB::table('tasks')->whereBetween('reported_date', array($from, $to))->get();

		return View::make('admin.customer-report.project', array(
			'projects' => $projects,
			'tasks' => $projectTasks)
		);
	}

}
