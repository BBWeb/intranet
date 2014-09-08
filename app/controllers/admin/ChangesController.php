<?php

class ChangesController extends \BaseController {

	private $project;

	public function __construct(Project $project)
	{
		$this->project = $project;
	}

	public function getIndex()
	{
		$projects = $this->project->lists('name', 'id');
		// we want a list of projects
		return \View::make('admin.changes.base', array(
			'projects' => $projects
			)
		);
	}

	public function postIndex()
	{
		$projectId = Input::get('project');

		$url = route('changes.project', array( $projectId ));

		return Redirect::to( $url );
	}

	public function getProject($id)
	{
		$projects = $this->project->lists('name', 'id');

		Session::flash('projectId', $id);
		$project = $this->project->find( $id );

		return View::make('admin.changes.project', array(
			'projects' => $projects,
			'project' => $project,
			'tasks' => $project->orderedTasks
			)
		);

	}
}