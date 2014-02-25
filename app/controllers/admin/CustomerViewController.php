<?php

class CustomerViewController extends BaseController {

public function getIndex()
   {
   		 $user = Auth::user();

      if ( $user->api_key == '2RJRtMFW.BrCLhhlyqymhV2VYgB2kWbF' ) return Redirect::to('account');

      // $asanaHandler = new AsanaHandler( $user->api_key );
      //	$projects = $asanaHandler->getProjects();
      $tasks = $user->tasks()->get();

      
      return View::make("admin.customer-report")->with('tasks', $tasks);
   }  
   
}
