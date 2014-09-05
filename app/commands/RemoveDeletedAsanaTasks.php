<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Intranet\Handlers\AsanaHandler;

class RemoveDeletedAsanaTasks extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'command:removedeletedasanatasks';

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
		$users = User::all();

		$fetchedAsanaTasks = [];

		foreach ($users as $user)
		{
			if ( $user->api_key == '' ) continue;

			$asana = new AsanaHandler( $user );

			// get list of assigned tasks to user
				// apppend to "global list"
			$assignedTasks = $asana->getAllAssignedTasks();

			foreach ($assignedTasks as $task)
			{
				array_push($fetchedAsanaTasks, $task->id);
			}

		}

		Log::info("Fetched asana tasks");
		Log::info(print_r($fetchedAsanaTasks, true));

		$storedAsanaTasks = AsanaTask::where('completed', '=', false)->lists('id');  // get all non completed

		Log::info("Stored asana tasks");
		Log::info(print_r($storedAsanaTasks, true));

		$diffTasks = array_diff($storedAsanaTasks, $fetchedAsanaTasks);

		Log::info("Diff tasks");
		Log::info(print_r($diffTasks, true));

		$asanaKey = $_ENV['ASANA_KEY'];

		AsanaHandler::deleteNotFoundTasks($asanaKey, $diffTasks);
		// compare the global asana list to our local non completed tasks
			// which meeans get the diff from these sets

		// with the resulting diff, go through and check the current status of these
		 // if not found in asana they should be completed or dropped!
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
