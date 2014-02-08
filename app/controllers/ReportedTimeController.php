<?php

class ReportedTimeController extends BaseController {

   public function getIndex()
   {
   	 $tasks = Auth::user()->tasks()->whereStatus('reported')->get();


      return View::make("user.reported-time")->with('tasks', $tasks);
   }
}


