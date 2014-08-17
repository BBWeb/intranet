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
      $task = $this->task->find( $id );

      $taskTitle = $task->modifiedNameIfAny();
      $taskDate = $task->modifiedDateIfAny();

      // return json
      return Response::json(array(
         'id' => $task->id,
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

   public function postConnectAsana()
   {
      $user = Auth::user();

      $privateTaskId = Input::get('private_task_id');
      $asanaTaskId = Input::get('asana_task_id');
      $projectId = Input::get('project_id');
      $name = Input::get('name');
      $projectName = Input::get('project_name');

      $project = $this->project->find( $projectId );

      if ( !$project ) {
         $project = $this->project->create(array(
            'id' => $projectId,
            'name' => $projectName
         ));
      }

      // find task for the current user and asana id
      $task = $this->task->where('user_id', '=', $user->id)->where('asana_id', '=', $asanaTaskId)->first();

      // if there is none, create one
      if ( !$task ) {
         $task = $this->task->create(array(
            'user_id' => $user->id,
            'asana_id' => $asanaTaskId,
            'project_id' => $projectId,
            'task' => $name 
         ));
      }

      $privateTask = PrivateTask::find( $privateTaskId );

      // transfer private task data to a subreport 
      $todaysDate = date('Y-m-d');

      $subreport = $this->subreport->create([
         'task_id' => $task->id,
         'reported_date' => $todaysDate,
         'name' => $privateTask->name,
         'time' => $privateTask->time_worked
      ]); 

      $privateTask->delete();

      // create a new subreport with the current date

      // get the private task info and create a new subreport with time
      // return $subreport;
      return Response::json([
         'task_id' => $task->id,
         'template' => View::make('templates.reported_task')->with('task', $task)->render()
      ]);
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

   public function postUpdateSubreport()
   {
      $id = Input::get('id');

      $subreport = $this->subreport->find( $id );

      if ($subreport && !$subreport->payed) {
         $subreport->name = Input::get('name');
         $subreport->time = Input::get('time');

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
