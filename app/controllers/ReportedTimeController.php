<?php

class ReportedTimeController extends BaseController {

   public function getIndex()
   {
	   	$tasks = Auth::user()->tasks()->with('subreports')->get();

		  return View::make("user.reported-time")->with('tasks', $tasks);
   }
}


