<?php

class CustomerViewController extends BaseController {

	public function getIndex()
	{
	    $projects = Project::all();

	    return View::make('admin.customer-report.base')->with('projects', $projects);
	}

	public function getProjectOverview($projectId, $fromStr, $toStr)
	{
		$projects = Project::all();

		$project = Project::find($projectId);

	    $from = date('Y-m-d', strtotime($fromStr));
  		$to = date('Y-m-d', strtotime($toStr));
	    $projectTasks = $project->tasks()->whereBetween('reported_date', array($from, $to))->get();

	    $totalTime = 0;
	    foreach ($projectTasks as $task) {
	    	$totalTime += $task->time_worked;
	    }

		return View::make('admin.customer-report.project',
			array(
				'from' => $from,
				'to' => $to,
				'projects' => $projects,
				'project' => $project,
				'totalTime' => $totalTime,
				'tasks' => $projectTasks
			)
		);
	}

	public function printProjectOverview($projectId, $fromStr, $toStr)
	{
		$project = Project::find($projectId);

	    $from = date('Y-m-d', strtotime($fromStr));
  		$to = date('Y-m-d', strtotime($toStr));
	    $projectTasks = $project->tasks()->whereBetween('reported_date', array($from, $to))->get();

	    $totalTime = 0;
	    // go through all "adjusted time wich are not set"
	    foreach ($projectTasks as $projectTask) {

	    	if ( $projectTask->adjusted_time == 0) {
	    		$projectTask->adjusted_time = $projectTask->time_worked;
	    		$projectTask->save();
	    	}
	    	$totalTime += $projectTask->adjusted_time;
	    }

	    return View::make('admin.customer-report.print', array(
	    	'from' => $from,
	    	'to' => $to,
	    	'totalTime' => $totalTime,
	    	'project' => $project,
	    	'tasks' => $projectTasks
    	));
	}

}
