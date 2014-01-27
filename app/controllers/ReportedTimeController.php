<?php

class ReportedTimeController extends BaseController {

	public function index()
	{
		$tasks = Task::where('status', '=', 'reported')->get();

		return View::make('admin.reported-time')->with('tasks', $tasks);
	}

}