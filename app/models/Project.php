<?php

class Project extends Eloquent {

	protected $fillable = array('id', 'name');

	public function tasks() {
		return $this->hasMany('Task');
	}

	public function orderedTasks()
	{
		return $this->hasMany('Task')->orderBy('created_at');
	}
}