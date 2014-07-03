<?php

class ModifiedNameTask extends Eloquent {

	protected $table = 'modified_name_tasks';

	protected $fillable = array('task_id', 'modified_title');
}