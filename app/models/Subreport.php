<?php

class Subreport extends Eloquent {

	protected $table = 'subreports';

	protected $fillable = array(
    'task_id',
    'name',
    'reported_date',
    'time',
    'payed'
  );

	protected $softDelete = true;

  public static $rules = array(
    'name' => 'required|min:1',
    'time' => 'integer|min:0'
  );

  public function task() {
    return $this->belongsTo('Task');
  }

  public function formattedTime()
  {
    return $this->formatTime($this->time);
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