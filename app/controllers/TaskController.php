<?php

class TaskController extends BaseController {
   
   public function store()
   {
      $input = Input::only('id', 'project', 'name');

      // check if id already exists
      
      $task = new Task();
      $task->user_id = Auth::user()->id;
      $task->id = $input['id'];
      $task->project = $input['project'];
      $task->task = $input['name'];
      $task->save();

      return Response::json( $task->toJson() );
   }
}
