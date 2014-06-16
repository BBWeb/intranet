<?php

class Subreport extends Eloquent {

	protected $table = 'subreports';

	protected $fillable = array('task_id', 'reported_date', 'time');

	protected $softDelete = true;
}