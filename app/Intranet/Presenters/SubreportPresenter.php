<?php namespace Intranet\Presenters;

use McCool\LaravelAutoPresenter\BasePresenter;

class SubreportPresenter extends BasePresenter {

  public function __construct(\Subreport $subreport)
  {
    $this->resource = $subreport;
  }

  public function formattedTime()
  {
    $time = $this->resource->time;

    return $this->formatTime($time);
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