<?php

class ModifiedDateTask extends Eloquent {

	protected $table = 'modified_date_tasks';

	protected $fillable = array('task_id', 'modified_date');
}