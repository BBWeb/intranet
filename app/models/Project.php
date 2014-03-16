<?php

class Project extends Eloquent {

	public function tasks() {
		return $this->hasMany('tasks');
	}
}