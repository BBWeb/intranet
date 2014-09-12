<?php

class ModifiedDateAsanaTask extends Eloquent {

	protected $table = 'modified_date_tasks';

	protected $fillable = array('asana_task_id', 'modified_date');
}