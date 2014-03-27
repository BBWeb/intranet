<?php

class TaskController extends BaseController {

   public function postCreate()
   {
      $input = Input::only('asana_id', 'project_id', 'project_name', 'name');

      $projectId = $input['project_id'];
      $project = Project::find($projectId);

      if ( !$project ) {
         $project = new Project();
         $project->id = $projectId;
         $project->name = $input['project_name'];
         $project->save();
      }

      // check if id already exists
      $task = new Task();
      $task->user_id = Auth::user()->id;
      $task->asana_id = $input['asana_id'];
      $task->project_id = $input['project_id'];
      $task->task = $input['name'];
      $task->save();

      return Response::json( $task->toJson() );
   }

   public function postUpdateTime()
   {
      $id = Input::get('id');
      $timeWorked = Input::get('timeWorked');

      $task = Task::find( $id );

      // check if we already have a subreport for this day
      $todaysDate = date('Y-m-d');

      $subreport = $task->subreports()->where('reported_date', '=', $todaysDate)->first();
      if ( !$subreport ) {
         $subreport = new Subreport();
         $subreport->task_id = $task->id;
         $subreport->reported_date = $todaysDate;
      }

      $subreport->time = $timeWorked;
      $subreport->save();

      return Response::json( $subreport->toJson() );
   }

   public function postUpdateAdjustedTime()
   {
      $id = Input::get('id');
      $task = Task::find( $id );
      $task->adjusted_time = Input::get('adjusted-time');
      $task->save();

      return Response::json( $task->toJson() );
   }

   public function postReport()
   {
      $id = Input::get('id');

      $task = Task::find( $id );

      $task->reported_date = date('Y-m-d');
      $task->status = 'reported';

      $task->save();

      return Response::json( $task->toJson() );
   }

   public function postRemove()
   {
      $id = Input::get('id');

      Task::destroy( $id );
   }
}
