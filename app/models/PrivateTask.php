<?php

class PrivateTask extends Eloquent {

  protected $table = 'private_tasks';

  protected $fillable = array(
    'user_id',
    'name',
    'time_worked'
  );
}