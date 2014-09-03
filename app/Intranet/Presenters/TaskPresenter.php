<?php namespace Intranet\Presenters;

use McCool\LaravelAutoPresenter\BasePresenter;

class TaskPresenter extends BasePresenter {

  public function __construct(\Task $task)
  {
    $this->resource = $task;
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

}
