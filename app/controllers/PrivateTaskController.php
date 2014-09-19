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

    return Response::json([
      'template' => View::make('templates.private_task')->with('privateTask', $privateTask)->render()
    ]);
  }

  public function update($id)
  {
    $privateTask = $this->privateTask->find($id);

    $input = Input::only('name', 'time_worked');

    $validator = Validator::make($input, PrivateTask::$rules);

    if ( $validator->passes() ) {
      $privateTask->update($input);
    }

    return $privateTask;
  }

  public function destroy($id)
  {
    $privateTask = $this->privateTask->find($id);

    return Response::json([ 'deleted' => $privateTask->delete() ]);
  }

}