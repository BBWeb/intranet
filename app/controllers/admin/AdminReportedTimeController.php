<?php

class AdminReportedTimeController extends BaseController {

	private $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function getIndex()
	{
		$users = $this->user->lists('name', 'id');

		return \View::make('admin.staff-report.base')->with(array('users' => $users));
	}

	public function getTimeReport($userId, $fromStr, $toStr)
	{
		$users = $this->user->lists('name', 'id');

		$user = $this->user->find( $userId );

	    $from = date('Y-m-d', strtotime( $fromStr ));
  		$to = date('Y-m-d', strtotime( $toStr ));

		// add option for admin to mark tasks as "payed"
    	// TODO we should only get tasks with "unpayed" subreports
    	// This also means that the "totaltime" that we want to see in this view is unreported time
		$unpayedTasks = $user->unpayedTasksBetween($from, $to);

		$totalTime = 0;
		foreach ($unpayedTasks as $unpayedTask) {
			$totalTime += $unpayedTask->totalUnpayedTimeBetween( $from, $to );
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


	// take input options user, dateinterval and create a route from em
	public function filterTimeReport()
	{
		// get input user, from, to	
		$input = Input::only('user', 'from', 'to');

		$url = route('getTimeReport', $input);
		return Redirect::to( $url );
	}

  public function getPayedIndex()
  {
    $users = $this->user->all();

    return View::make('admin.staff-report.payed', array('users' => $users));
  }

  public function getPayedUser($userId)
  {
    $users = $this->user->all();
  	$user = $this->user->find($userId);

  	$payedTasks = $user->payedTasks();

    return View::make('admin.staff-report.payed-report', array(
    	'users' => $users,
      'tasks' => $payedTasks
  	));
  }

}
