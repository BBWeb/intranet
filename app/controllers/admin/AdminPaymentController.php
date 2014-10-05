<?php

class AdminPaymentController extends BaseController {

  private $subreport;

  public function __construct(Subreport $subreport)
  {
    $this->subreport = $subreport;
  }

  public function payTasks()
  {
    $tasks = Input::get('tasks', []);

      // // find unpayed subreports for these tasks and check them of as payed
    foreach ($tasks as $taskId => $task) {
     $subreports = $task['subreports'];

      foreach ($subreports as $subreportId) {
        $subreport = $this->subreport->find($subreportId);
        $subreport->payed = true;
        $subreport->save();
      }
    }
  }

}