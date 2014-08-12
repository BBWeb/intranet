<?php

class ProjectsController extends BaseController {

	private $project;

	public function __construct(Project $project)
	{
		$this->project = $project;
	}

	public function getIndex()
	{
		$user = Auth::user();

		$privateTasks = $user->privateTasks;

		$projects = $this->project->lists('name', 'id');

		$projectId = Input::get('project');
		Session::flash('project', $projectId);

		$tasks;

		if ( $projectId == '' || $projectId == 'all' ) {
			$tasks = $user->notreportedTasks;
		} else {
			$tasks = $user->notreportedTasksFor( $projectId )->get();
		}

		return View::make('user.start', array(
			'projects' => $projects,
			'privateTasks' => $privateTasks,
			'tasks' => $tasks
			)
		);
	}

}

