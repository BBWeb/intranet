<?php

class TaskController extends BaseController {

   public function store()
   {
      $input = Input::only('asana_id', 'project_id', 'name');

      // check if id already exists
      $task = new Task();

      $task->user_id = Auth::user()->id;

      $task->asana_id = $input['asana_id'];
      $task->project_id = $input['project_id'];
      $task->task = $input['name'];

      $task->save();

      return Response::json( $task->toJson() );
   }

   public function updateTime()
   {
      $id = Input::get('id');

      $task = Task::find( $id );

      $task->time_worked = Input::get('timeWorked');

      $task->save();

      return Response::json( $task->toJson() );
   }

   public function report()
   {
      $id = Input::get('id');

      $task = Task::find( $id );

      $task->reported_date = date('Y-m-d');
      $task->status = 'reported';

      $task->save();

      return Response::json( $task->toJson() );
   }

   public function delete(){

      $id = Input::get('id');

      Task::destroy( $id );
   }
}
