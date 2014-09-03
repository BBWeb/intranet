<?php

class AsanaTask extends Eloquent {

  protected $table = 'asana_tasks';

  protected $fillable = [
    'id',
    'name',
    'completed',
    'project_id',
    'user_id'
  ];

  public function project()
  {
    return $this->belongsTo('Project');
  }

}