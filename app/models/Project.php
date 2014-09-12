<?php

class Project extends Eloquent {

	protected $fillable = array('id', 'name');

	public function tasks() {
		return $this->hasManyThrough('Task', 'AsanaTask', 'project_id', 'asana_task_id');
	}

	public function asanatasks()
	{
		return $this->hasMany('AsanaTask');
	}

	public function orderedAsanaTasks()
	{
		return $this->asanatasks()->orderBy('created_at');
	}

	public function tasksForCustomerBetween($dateFrom, $dateTo)
	{
		// get modified tasks for this project, with modified_date between the date interval
		$modifiedTasks = DB::table('asana_tasks')
			->selectRaw('asana_tasks.*, modified_date_tasks.asana_task_id, modified_date_tasks.modified_date')
			->leftJoin('modified_date_tasks', 'asana_tasks.id', '=', 'modified_date_tasks.asana_task_id')
			->where('asana_tasks.project_id', '=', $this->id)
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

		$notModifiedTasks = DB::table('asana_tasks')
			->selectRaw('asana_tasks.*, modified_date_tasks.id, asana_tasks.completion_date')
			->leftJoin('modified_date_tasks', 'asana_tasks.id', '=', 'modified_date_tasks.asana_task_id')
			->whereRaw('NOT EXISTS( SELECT * FROM modified_date_tasks where modified_date_tasks.asana_task_id = asana_tasks.id )')
			->where('asana_tasks.project_id', '=', $this->id)
			->whereBetween('asana_tasks.completion_date', [ $dateFrom, $dateTo ]);

		// create a union between the modified tasks and the not modified tasks
		$filteredTasks = AsanaTask::hydrate( $modifiedTasks->union($notModifiedTasks)->get() );

		return $filteredTasks;
	}

	public function orderedTasks()
	{
		return $this->tasks()->orderBy('created_at');
	}
}