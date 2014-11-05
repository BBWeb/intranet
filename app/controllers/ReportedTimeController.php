<?php

class ReportedTimeController extends BaseController {

	private $project;

	public function __construct(Project $project)
	{
		$this->project = $project;
	}

	public function getIndex()
	{
		$user = Auth::user();

		$projects =  $this->project->lists('name', 'id');

		// define in helper functions
		$lastMonthTimeStamp = mktime(0, 0, 0, date('m') - 1, 1, date('Y'));

		// first day of last month
		$defaultFromDate =  date('d-m-Y', $lastMonthTimeStamp);
		Session::flash('from', $defaultFromDate);

		// last date in last month
		$defaultToDate = date('t-m-Y', $lastMonthTimeStamp);
		Session::flash('to', $defaultToDate);

		// redirect to filter viewed // with all set
		$url = route('reported-time.showFilter', [ 'all', $defaultFromDate, $defaultToDate ]);
		return Redirect::to( $url );
	}

	/**
	 * Shows users tasks for a specific project
	 * @param  [Integer] $id The identifier of the project to display
	 * @return [View]    View containing tasks
	 */
	public function showFilter($projectId, $fromStr, $toStr)
	{
		$user = Auth::user();

		Session::flash('project', $projectId);

		Session::flash('from', $fromStr);
		Session::flash('to', $toStr);

		$projects =  $this->project->lists('name', 'id');

		$fromDate = date('Y-m-d', strtotime($fromStr));
		$toDate = date('Y-m-d', strtotime($toStr));

		if ($projectId == 'all')
		{
			$userTasks = $user->tasksWithSubreportsBetween($fromDate, $toDate);
		}
		else
		{
			$userTasks = $user->projectTasksWithSubreportsBetween($projectId, $fromDate, $toDate);
		}


		// get the selected project
		// $project = $this->project->find( $id );

		// get all of this users task which is connected to the project through an asana task
		// $userTasksInProjectQuery = $project->tasks()->where('tasks.user_id', '=', $user->id); // collision with user id on asana table, therefore tasks.user_id
		// $userTasksInProject = $userTasksInProjectQuery->with('subreports')->get();

		$totalUnpayedInMinutes = $this->totalUnpayedFor( $userTasks );
		$totalUnpayed = $this->getTimeObj( $totalUnpayedInMinutes );

		$totalPayedInMinutes = $this->totalPayedFor( $userTasks );
		$totalPayed = $this->getTimeObj( $totalPayedInMinutes );

		return View::make('user.reported-time', array(
			'projects' => $projects,
			'totalUnpayed' => $totalUnpayed,
			'totalPayed' => $totalPayed,
			'tasks' => $userTasks
			)
		);
	}

	/**
	 * Takes input form incoming post request and formats a new request to match
	 * search criteria
	 */
	public function filter()
	{
		$input = Input::only('project', 'from', 'to');

		$url = route('reported-time.showFilter', $input);
		return Redirect::to( $url );
	}

	private function totalUnpayedFor($tasks)
	{
		$unpayed = 0;

		foreach ($tasks as $task) {
			$unpayed += $task->totalUnpayedTime();
		}

		return $unpayed;
	}

	public function totalPayedFor($tasks)
	{
		$payed = 0;

		foreach ($tasks as $task)
		{
			$payed += $task->totalPayedTime();
		}

		return $payed;
	}

	public function getTimeObj($minutes)
	{
		$timeObj = new stdClass();

		$timeObj->hours = floor( $minutes / 60 );
		$timeObj->minutes = $minutes % 60;

		return $timeObj;
	}

}

