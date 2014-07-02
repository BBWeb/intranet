<?php

class Subreport extends Eloquent {

	protected $table = 'subreports';

	protected $fillable = array('task_id', 'reported_date', 'time', 'payed');

	protected $softDelete = true;
}