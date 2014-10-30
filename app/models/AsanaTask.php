<?php

class AsanaTask extends Eloquent {

  public $presenter = 'Intranet\Presenters\AsanaTaskPresenter';


  protected $table = 'asana_tasks';

  protected $fillable = [
    'id',
    'name',
    'completed',
    'project_id',
    'adjusted_time',
    'user_id'
  ];

  public function project()
  {
    return $this->belongsTo('Project');
  }

  public function subreports()
  {
    return $this->hasManyThrough('Subreport', 'Task', 'asana_task_id', 'task_id');
  }

  public function totaltime()
  {
    $subreports = $this->subreports;

    $totalTime = 0;
    foreach ($subreports as $subreport)
    {
      $totalTime += $subreport->time;
    }

    return $totalTime;
  }

  public function adjustedTimeIfAny()
  {
    $time = $this->totaltime();

    if ($this->adjusted_time > 0) {
      $time = $this->adjusted_time;
    }

    return $time;
  }


  public function tasks()
  {
    return $this->hasMany('Task', 'asana_task_id');
  }

  public function modifiedTaskDate()
  {
    return $this->hasOne('ModifiedDateAsanaTask', 'asana_task_id');
  }

   public function modifiedTaskName()
   {
      return $this->hasOne('ModifiedNameAsanaTask', 'asana_task_id');
   }

   public function modifiedNameIfAny()
   {
      $title = $this->name;

      $modifiedNameTask = $this->modifiedTaskName;

      if ( $modifiedNameTask )
      {
       $title = $modifiedNameTask->modified_title;
     }

     return $title;
   }

   public function modifiedDateIfAny()
   {
      $date = $this->completion_date;

      $modifiedDateTask = $this->modifiedTaskDate;

      if ( $modifiedDateTask )
      {
         $date = $modifiedDateTask->modified_date;
      }

      return $date;
   }

}