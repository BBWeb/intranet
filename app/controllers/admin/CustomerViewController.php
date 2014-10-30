<?php

class CustomerViewController extends BaseController {

	private $project;

	public function __construct(Project $project)
	{
		$this->project = $project;
	}

	public function getIndex()
	{
	    $projects = $this->project->lists('name', 'id');

   		// define in helper functions
		$lastMonthTimeStamp = mktime(0, 0, 0, date('m') - 1, 1, date('Y'));

		// first day of last month
		$defaultFromDate =  date('d-m-Y', $lastMonthTimeStamp);
		Session::flash('from', $defaultFromDate);

		// last date in last month
		$defaultToDate = date('t-m-Y', $lastMonthTimeStamp);
		Session::flash('to', $defaultToDate);

		return View::make('admin.customer-report.base')->with('projects', $projects);
	}

	public function filter()
	{
		$input = Input::only('project', 'from', 'to');

		$url = route('customer.getTimeReport', $input);
		return Redirect::to( $url );
	}

	public function getProjectOverview($projectId, $fromStr, $toStr)
	{
		$projects = $this->project->lists('name', 'id');

		Session::flash('projectId', $projectId);
		$project = $this->project->find($projectId);

		Session::flash('from', $fromStr);
		$from = date('Y-m-d', strtotime($fromStr));

		Session::flash('to', $toStr);
		$to = date('Y-m-d', strtotime($toStr));

		$projectTasks = $project->tasksForCustomerBetween($from, $to);

	    // return $tasks;
		$totalTime = 0;
		foreach ($projectTasks as $task) {
			$totalTime += $task->totaltime();
		}

		$totalTimeHours = floor($totalTime / 60);
		$totalTimeMinutes = $totalTime % 60;

		return View::make('admin.customer-report.project',
			array(
				'from' => $from,
				'to' => $to,
				'projects' => $projects,
				'project' => $project,
				'totalTime' => $totalTime,
				'totalTimeHours' => $totalTimeHours,
				'totalTimeMinutes' => $totalTimeMinutes,
				'tasks' => $projectTasks
			)
		);
	}

	public function printProjectOverview($projectId, $fromStr, $toStr)
	{
		Session::flash('projectId', $projectId);
		$project = $this->project->find($projectId);

	    $from = date('Y-m-d', strtotime($fromStr));
  		$to = date('Y-m-d', strtotime($toStr));

	    $projectTasks = $project->tasksForCustomerBetween($from, $to);

	    $totalTime = 0;
	    // go through all "adjusted time wich are not set"
	    foreach ($projectTasks as $projectTask)
	    {
	    	if ( $projectTask->adjusted_time == 0) {
	    		$projectTask->adjusted_time = $projectTask->totaltime();
	    		$projectTask->save();
	    	}
	    	$totalTime += $projectTask->adjusted_time;
	    }

	    $hours = floor($totalTime / 60);
	    $minutes = $totalTime % 60;

	    return View::make('admin.customer-report.print', array(
	    	'from' => $from,
	    	'to' => $to,
	    	'hours' => $hours,
	    	'minutes' => $minutes,
	    	'project' => $project,
	    	'tasks' => $projectTasks
    	));
	}

}
