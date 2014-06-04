<?php

class AdminReportedTimeController extends BaseController {

	public function getIndex()
	{
		$users = User::all();

		return \View::make('admin.staff-report.base')->with(array('users' => $users));
	}

	public function getTimeReport($userId, $fromStr, $toStr)
	{
		$users = User::all();

		$user = User::find($userId);

	    $from = date('Y-m-d', strtotime($fromStr));
  		$to = date('Y-m-d', strtotime($toStr));

		// add option for admin to mark tasks as "payed"
    	// TODO we should only get tasks with "unpayed" subreports
    	// This also means that the "totaltime" that we want to see in this view is unreported time
		$unpayedTasks = $user->unpayedTasksBetween($from, $to);

		$totalTime = 0;
		foreach ($unpayedTasks as $unpayedTask) {
			$totalTime += $unpayedTask->totalUnpayedTimeBetween($from, $to);
		}

		return View::make('admin.staff-report.index',
			array(
        		'users' => $users,
				'tasks' => $unpayedTasks,
				'from' => $from,
				'to' => $to,
				'totaltime' => $totalTime
			)
		);
	}

  public function getPayedIndex()
  {
    $users = User::all();

    return View::make('admin.staff-report.payed', array('users' => $users));
  }

  public function getPayedUser($userId)
  {
    $users = User::all();
  	$user = User::find($userId);

  	$payedTasks = $user->payedTasks();

    return View::make('admin.staff-report.payed-report', array(
    	'users' => $users,
      'tasks' => $payedTasks
  	));
  }

}
