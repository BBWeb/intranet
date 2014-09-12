<?php

class ModifiedNameAsanaTask extends Eloquent {

	protected $table = 'modified_name_tasks';

	protected $fillable = array('asana_task_id', 'modified_title');
}