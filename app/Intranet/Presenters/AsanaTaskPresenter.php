<?php namespace Intranet\Presenters;

use McCool\LaravelAutoPresenter\BasePresenter;

class AsanaTaskPresenter extends BasePresenter {

  public function __construct(\AsanaTask $asanaTask) {
    $this->resource = $asanaTask;
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

    return ($hours < 9 ? '0' : '') . $hours . ':' . $minutes . ($minutes < 9 ? '0' : '');
  }


}