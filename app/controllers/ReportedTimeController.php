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
		$tasks = $user->tasks()->with('subreports')->get();

		$totalUnpayedInMinutes = $this->totalUnpayedFor( $tasks );
		$totalUnpayed = $this->getTimeObj( $totalUnpayedInMinutes );

		$totalPayedInMinutes = $this->totalPayedFor( $tasks );
		$totalPayed = $this->getTimeObj( $totalPayedInMinutes );

		return View::make('user.reported-time', array(
			'projects' => $projects,
			'totalUnpayed' => $totalUnpayed,
			'totalPayed' => $totalPayed,
			'tasks' => $tasks
			)
		);
	}

	/**
	 * Shows users tasks for a specific project
	 * @param  [Integer] $id The identifier of the project to display 
	 * @return [View]    View containing tasks 
	 */
	public function showProject($id)
	{
		$user = Auth::user();

		Session::flash('project', $id);

		$projects =  $this->project->lists('name', 'id');

		$projectTasksQuery = $user->tasks()->where('project_id', '=', $id);
		$projectTasks = $projectTasksQuery->with('subreports')->get();

		$totalUnpayedInMinutes = $this->totalUnpayedFor( $projectTasks );
		$totalUnpayed = $this->getTimeObj( $totalUnpayedInMinutes );

		$totalPayedInMinutes = $this->totalPayedFor( $projectTasks );
		$totalPayed = $this->getTimeObj( $totalPayedInMinutes );

		return View::make('user.reported-time', array(
			'projects' => $projects,
			'totalUnpayed' => $totalUnpayed,
			'totalPayed' => $totalPayed,
			'tasks' => $projectTasks
			)
		);
	}

	/**
	 * Takes input form incoming post request and formats a new request to match 
	 * search criteria
	 */
	public function filter()
	{
		$project = Input::get('project');
		if ( $project == 'all' )
		{
			return Redirect::route('reported-time.index');
		}

		$input = Input::only('project');
		$url = route('reported-time.showProject', $input);

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

