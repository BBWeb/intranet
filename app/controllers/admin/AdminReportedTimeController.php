<?php

class AdminReportedTimeController extends BaseController {

	public function getIndex()
	{
		$users = User::all();

		return \View::make('admin.staff-report.base')->with(array('users' => $users));
	}

	public function getTimeReport($userId)
	{
		$users = User::all();

		$user = User::find($userId);

		// add option for admin to mark tasks as "payed"
    	// TODO we should only get tasks with "unpayed" subreports
    	// This also means that the "totaltime" that we want to see in this view is unreported time
		$unpayedTasks = $user->unpayedTasks();

		return View::make('admin.staff-report.index',
			array(
        		'users' => $users,
				'tasks' => $unpayedTasks
			)
		);
	}

  public function getPayedIndex()
  {
    $users = User::all();

    return View::make('admin.staff-report.payed', array('users' => $users));
  }

}
