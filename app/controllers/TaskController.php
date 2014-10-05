<?php

use Intranet\Service\Task\TaskModifierService;

class TaskController extends BaseController {

   private $task;
   private $project;
   private $subreport;
   private $taskModifier;

   public function __construct(Task $task, Project $project, Subreport $subreport, TaskModifierService $taskModifier)
   {
      $this->task = $task;
      $this->project = $project;
      $this->subreport = $subreport;
      $this->taskModifier = $taskModifier;
   }

   public function getIndex($taskId)
   {
      $task = $this->task->find( $taskId );
      $subreports = $task->subreports;

      return Response::json( $subreports->toJson() );
   }

   /**
    * Returns name and date, if modified data exists then returns that
    * @param  [integer] $id
    * @return [json] id, title, date
    */
   public function getModifiedTaskData($id)
   {
      $asanaTask = AsanaTask::find($id);
      $taskTitle = $asanaTask->modifiedNameIfAny();
      $taskDate = $asanaTask->modifiedDateIfAny();

      // return json
      return Response::json(array(
         'id' => $asanaTask->id,
         'completed' => (bool) $asanaTask->completed,
         'title' => $taskTitle,
         'date' => $taskDate
         )
      );

   }

   public function putModifyTask($id)
   {
      $this->taskModifier->modifyTask( $id, Input::all() );

      return Response::json(array('id' => $id));
   }

   public function postCreateSubreport()
   {
      $user = Auth::user();

      // get the task id
      $reportedTaskId = Input::get('task_id');

      $task = $this->task->find( $reportedTaskId );

      $todaysDate = date('Y-m-d');

      $subreport = $this->subreport->create([
         'task_id' => $task->id,
         'reported_date' => $todaysDate,
         'name' => Input::get('name'),
         'time' => Input::get('time_worked')
      ]);

      return Response::json([
         'task_id' => $task->id,
         'template' => View::make('templates.reported_task')->with('task', $task)->render()
      ]);
   }

   public function postAddPrivateToTask() {
      $user = Auth::user();

      $privateTaskId = Input::get('private_task_id');
      $reportedTaskId = Input::get('reported_task_id');

      $task = $this->task->find( $reportedTaskId );

      $privateTask = PrivateTask::find( $privateTaskId );

      $todaysDate = date('Y-m-d');

      $subreport = $this->subreport->create([
         'task_id' => $task->id,
         'reported_date' => $todaysDate,
         'name' => $privateTask->name,
         'time' => $privateTask->time_worked
      ]);

      $privateTask->delete();

      return Response::json([
         'task_id' => $task->id,
         'template' => View::make('templates.reported_task')->with('task', $task)->render()
      ]);
   }

   public function postConnectAsana()
   {
      $user = Auth::user();

      $privateTaskId = Input::get('private_task_id');
      $asanaTaskId = Input::get('asana_task_id');

      $asanaTask = AsanaTask::find( $asanaTaskId );

      // find task for the current user and asana id
      $task = $this->task->where('user_id', '=', $user->id)->where('asana_task_id', '=', $asanaTaskId)->first();

      // if there is none, create one
      if ( !$task ) {
         $task = $this->task->create(array(
            'user_id' => $user->id,
            'asana_task_id' => $asanaTaskId
         ));
      }

      $privateTask = PrivateTask::find( $privateTaskId );

      $todaysDate = date('Y-m-d');

      $attributes = [
         'task_id' => $task->id,
         'reported_date' => $todaysDate,
         'name' => $privateTask->name,
         'time' => $privateTask->time_worked
      ];

      // transfer private task data to a subreport
      $subreport = $this->subreport->create($attributes);
      $privateTask->delete();

      // create a new subreport with the current date

      // get the private task info and create a new subreport with time
      // return $subreport;
      return Response::json([
         'task_id' => $task->id,
         'template' => View::make('templates.reported_task')->with('task', $task)->render()
      ]);
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

   public function postUpdateSubreport()
   {
      $id = Input::get('id');

      $attributes = Input::only('name', 'time');

      $subreport = $this->subreport->find( $id );

      // if we didnt find the subreport or if its already payed for
      if (!$subreport || $subreport && $subreport->payed) return;

      $validator = Validator::make($attributes, Subreport::$rules);

      if ( $validator->passes() ) {
         $subreport->update($attributes);
      }
   }

   public function postUpdateAdjustedTime()
   {
      $id = Input::get('id');
      $asanaTask = AsanaTask::find( $id );
      $asanaTask->adjusted_time = Input::get('adjusted-time');
      $asanaTask->save();

      return Response::json( $asanaTask->toJson() );
   }

   public function postReport()
   {
      $id = Input::get('id');

      $asanaTask = AsanaTask::find($id);

      $asanaTask->completed = true;
      $asanaTask->completion_date = date('Y-m-d');

      $asanaTask->update();

      return Response::json( $asanaTask->toJson() );
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

   public function putMoveSubreport($subreportId)
   {
      $response;
      $subreport = $this->subreport->find( $subreportId );

      if ($subreport->payed)
      {
         $response = Response::json([
            'body' => 'Already payed, not possible to change task'
         ], 422);
         // 422 seems to be an acceptable return code for business rules violations
      }
      else
      {
         $subreport->task_id = Input::get('reported_task_id');
         $subreport->save();

         $task = $subreport->task;
         // return new view
         $response = Response::json([
            'task_id' => $task->id,
            'template' => View::make('templates.reported_task')->with('task', $task)->render()
         ]);
      }

      return $response;
   }

   public function postUndoSubreportRemove()
   {
      $id = Input::get('id');

      $subreport = $this->subreport->withTrashed()->find($id);
      $subreport->restore();
   }

}
