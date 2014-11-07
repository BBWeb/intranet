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

  public function modifiedNameIfAny()
  {
    $asanaTask = $this->resource->asanatask;

    return $asanaTask->modifiedNameIfAny();
  }

  public function modifiedDateIfAny()
  {
    $asanaTask = $this->resource->asanatask;

    return $asanaTask->modifiedDateIfAny();
  }

  public function projectName()
  {
    $asanaTask = $this->resource->asanatask;

    return $asanaTask->project->name;
  }

  public function formattedUnpayedTimeForPeriod($fromDate, $toDate)
  {
    $totalUnpayedTime = $this->resource->totalUnpayedTimeBetween($fromDate, $toDate);

    return $this->formatTime($totalUnpayedTime);
  }

  public function formattedTotalTimeForPeriod($fromDate, $toDate)
  {
    $totalTime = $this->resource->totaltimeBetween($fromDate, $toDate);

    return $this->formatTime($totalTime);
  }

  public function formattedUnpayedTime()
  {
    $totalUnpayedTime = $this->resource->totalUnpayedTime();

    return $this->formatTime($totalUnpayedTime);
  }

  public function formattedTotalTime()
  {
    $totalTime = $this->resource->totaltime();

    return $this->formatTime($totalTime);
  }

  /**
   *  Formats time to HH:mm
   * @param  integer $time in minutes
   * @return String      Formatted time
   */
  private function formatTime($time)
  {
    $hours = floor($time / 60);
    $minutes = $time % 60;

    return ($hours < 9 ? '0' : '') . $hours . ':' . ($minutes < 10 ? '0' : '') . $minutes;
  }

}
