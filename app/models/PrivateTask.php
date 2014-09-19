<?php

class PrivateTask extends Eloquent {

  protected $table = 'private_tasks';

  public static $rules = array(
    'name' => 'required|min:1',
    'time_worked' => 'integer|min:0'
  );

  protected $fillable = array(
    'user_id',
    'name',
    'time_worked'
  );

}