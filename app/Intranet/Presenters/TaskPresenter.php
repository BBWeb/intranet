<?php namespace Intranet\Presenters;

use McCool\LaravelAutoPresenter\BasePresenter;

class TaskPresenter extends BasePresenter {

  public function __construct(\Task $task)
  {
    $this->resource = $task;
  }

  public function completionDate()
  {
    $asanaTask = $this->resource->asanatask;

    return $asanaTask->completion_date;
  }

  public function taskName()
  {
    $asanaTask = $this->resource->asanatask;

    return $asanaTask->name;
  }

  public function projectName()
  {
    $asanaTask = $this->resource->asanatask;

    return $asanaTask->project->name;
  }

  public function adjustedTimeIfAny()
  {
    $time = $this->resource->totaltime();

    if ($this->resource->adjusted_time > 0) {
      $time = $this->resource->adjusted_time;
    }

    return $time;
  }

}
