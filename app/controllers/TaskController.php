<?php

class TaskController extends BaseController {

   public function getIndex($taskId)
   {
      $task = Task::find($taskId);
      $subreports = $task->subreports;

      return Response::json( $subreports->toJson() );
   }

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

      $subreport = $task->subreports()->where('reported_date', '=', $todaysDate)->wherePayed(false)->first();
      if ( !$subreport ) {
         $subreport = new Subreport();
         $subreport->task_id = $task->id;
         $subreport->reported_date = $todaysDate;
      }

      $subreport->time = $timeWorked;
      $subreport->save();

      return Response::json( $subreport->toJson() );
   }

   public function postUpdateSubreportTime()
   {
      $id = Input::get('id');
      $timeWorked = Input::get('timeWorked');

      $subreport = Subreport::find($id);

      if ($subreport && !$subreport->payed) {
         $subreport->time = $timeWorked;
         $subreport->save();
      }
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

   public function postRemoveSubreport()
   {
      $id = Input::get('id');
      $subreport = Subreport::find($id);

      if ( $subreport && !$subreport->payed ) $subreport->delete();

      return Response::json();
   }

   public function postUndoSubreportRemove()
   {
      $id = Input::get('id');

      $subreport = Subreport::withTrashed()->find($id);
      $subreport->restore();
   }

   public function postPay()
   {
      $tasks = Input::get('tasks');

      // // find unpayed subreports for these tasks and check them of as payed
      foreach ($tasks as $taskId => $task) {
         $subreports = $task['subreports'];

         foreach ($subreports as $subreportId) {
            $subreport = Subreport::find($subreportId);
            $subreport->payed = true;
            $subreport->save();
         }
      }
   }
}
