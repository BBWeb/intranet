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

		$tasks = $user->nonCompletedTasks()->with('subreports')->get();

		$asanaTasks = $user->allAsanaTasks();

		return View::make('user.start', array(
			'privateTasks' => $privateTasks,
			'asanaTasks' => $asanaTasks,
			'tasks' => $tasks
			)
		);
	}

}

