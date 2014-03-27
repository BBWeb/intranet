<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MoveReportedTimeAndDateToTimeReport extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'command:transformreportedtasks';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		// get all tasks
		$tasks = Task::all();

		// create subtasks for each
		foreach ($tasks as $task) {
			if ($task->status == 'notreported' && $task->time_worked == 0) continue;

			$subreport = new Subreport();
			$subreport->task_id = $task->id;
			$subreport->time = $task->time_worked;

			// if there is time reported for this task but it is not reported reported_date will be something like 00000_00_00
			$subreport->reported_date = $task->status == 'notreported' ? date('Y-m-d') : $task->reported_date;

			$subreport->save();
		}

	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
