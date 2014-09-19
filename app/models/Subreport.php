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
}