<?php

use Intranet\Handlers\AsanaHandler;

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

		$tasks = $user->nonCompletedTasks;

		$asanaTasks = $user->nonCompletedAsanaTasks;

		return View::make('user.start', array(
			'privateTasks' => $privateTasks,
			'asanaTasks' => $asanaTasks,
			'tasks' => $tasks
			)
		);
	}

}

