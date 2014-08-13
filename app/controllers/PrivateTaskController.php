<?php

class PrivateTaskController extends BaseController {

  private $privateTask;

  public function __construct(PrivateTask $privateTask)
  {
    $this->privateTask = $privateTask;
  }

  public function store()
  {
    $user = Auth::user();
    
    $input = Input::only('name', 'time_worked');

    $privateTask = $this->privateTask->create(['user_id' => $user->id] + $input);

    return $privateTask;
  }

  public function update($id) 
  {
    $privateTask = $this->privateTask->find( $id );

    $input = Input::only('name', 'time_worked');

    $privateTask->update($input);

    return $privateTask;
  }
  
}