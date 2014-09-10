<?php

class Project extends Eloquent {

	protected $fillable = array('id', 'name');

	public function tasks() {
		return $this->hasManyThrough('Task', 'AsanaTask', 'project_id', 'asana_task_id');
	}

	public function tasksForCustomerBetween($dateFrom, $dateTo)
	{
		// get modified tasks for this project, with modified_date between the date interval
		$modifiedTasks = DB::table('tasks')
			->selectRaw('tasks.*, modified_date_tasks.task_id, modified_date_tasks.modified_date')
			->leftJoin('modified_date_tasks', 'tasks.id', '=', 'modified_date_tasks.task_id')
			->where('tasks.project_id', '=', $this->id)
			->whereBetween('modified_date_tasks.modified_date', [ $dateFrom, $dateTo ]);

		// $notModifiedTasks = DB::table('tasks')
		// 	->selectRaw('tasks.*, modified_date_tasks.task_id, modified_date_tasks.modified_date')
		// 	->leftJoin('modified_date_tasks', 'tasks.id', '=', 'modified_date_tasks.task_id')
		// 	->where('tasks.project_id', '=', $this->id)
		// 	->whereBetween('tasks.reported_date', [ $dateFrom, $dateTo ])
		// 	->whereNotExists(function($query) {
		// 		$query->from('modified_date_tasks')
		// 			  ->where('modified_date_tasks.task_id', '=', 'tasks.id');
		// 	});

		// TODO, the query above should work (but doesn't)

		// get not modified tasks for this project, with a reported_date between the date interval
		// only get these if there are no modified dates for it

		$notModifiedTasks = DB::table('tasks')
			->selectRaw('tasks.*, asana_tasks.id, asana_tasks.completion_date')
			->join('asana_tasks', 'tasks.asana_task_id', '=', 'asana_tasks.id')
			->where('asana_tasks.project_id', '=', $this->id)
			->whereBetween('asana_tasks.completion_date', [ $dateFrom, $dateTo ]);

		// create a union between the modified tasks and the not modified tasks
		$filteredTasks = Task::hydrate( $modifiedTasks->union($notModifiedTasks)->get() );

		return $filteredTasks;
	}

	public function orderedTasks()
	{
		$meck = $this->tasks()->orderBy('created_at');
		return $meck;
	}
}