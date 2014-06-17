<?php

class TaskController extends BaseController {

   private $task;
   private $project;
   private $subreport;

   public function __construct(Task $task, Project $project, Subreport $subreport)
   {
      $this->task = $task;
      $this->project = $project;
      $this->subreport = $subreport;
   }

   public function getIndex($taskId)
   {
      $task = $this->task->find( $taskId );
      $subreports = $task->subreports;

      return Response::json( $subreports->toJson() );
   }

   public function postCreate()
   {
      $input = Input::only('asana_id', 'project_id', 'project_name', 'name');

      $projectId = $input['project_id'];
      $project = $this->project->find( $projectId );

      if ( !$project ) {
         $project = $this->project->create(array(
            'id' => $projectId,
            'name' => $input['project_name']
         ));
      }

      $task = $this->task->create(array(
         'user_id' => Auth::user()->id,
         'asana_id' => $input['asana_id'],
         'project_id' => $input['project_id'],
         'task' => $input['name']
      ));

      return Response::json( $task->toJson() );
   }

   public function postUpdateTime()
   {
      $id = Input::get('id');
      $timeWorked = Input::get('timeWorked');

      $task = $this->task->find( $id );
      // check if we already have a subreport for this day
      $todaysDate = date('Y-m-d');

      $subreport = $task->subreports()->where('reported_date', '=', $todaysDate)->wherePayed(false)->first();
      if ( !$subreport ) {
         $subreport = $this->subreport->create(array(
            'task_id' => $task->id,
            'reported_date' => $todaysDate
         ));
      }

      $subreport->time = $timeWorked;
      $subreport->save();

      return Response::json( $subreport->toJson() );
   }

   public function postUpdateSubreportTime()
   {
      $id = Input::get('id');
      $timeWorked = Input::get('timeWorked');

      $subreport = $this->subreport->find( $id );

      if ($subreport && !$subreport->payed) {
         $subreport->time = $timeWorked;
         $subreport->save();
      }
   }

   public function postUpdateAdjustedTime()
   {
      $id = Input::get('id');
      $task = $this->task->find( $id );
      $task->adjusted_time = Input::get('adjusted-time');
      $task->save();

      return Response::json( $task->toJson() );
   }

   public function postReport()
   {
      $id = Input::get('id');

      $task = $this->task->find( $id );

      $task->reported_date = date('Y-m-d');
      $task->status = 'reported';

      $task->save();

      return Response::json( $task->toJson() );
   }

   public function postRemove()
   {
      $id = Input::get('id');

      $this->task->destroy( $id );
   }

   public function postRemoveSubreport()
   {
      $id = Input::get('id');
      $subreport = $this->subreport->find( $id );

      if ( $subreport && !$subreport->payed ) $subreport->delete();

      return Response::json();
   }

   public function postUndoSubreportRemove()
   {
      $id = Input::get('id');

      $subreport = $this->subreport->withTrashed()->find($id);
      $subreport->restore();
   }

   public function postPay()
   {
      $tasks = Input::get('tasks');

      // // find unpayed subreports for these tasks and check them of as payed
      foreach ($tasks as $taskId => $task) {
         $subreports = $task['subreports'];

         foreach ($subreports as $subreportId) {
            $subreport = $this->subreport->find($subreportId);
            $subreport->payed = true;
            $subreport->save();
         }
      }
   }
}
