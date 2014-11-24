<?php

use Intranet\Api\AsanaApi;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CheckAsanaCompleteness extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'command:checkasanacompleteness';

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
		$apiKey = User::find(1)->api_key;

		$asanaApi = new AsanaApi($apiKey);
		// get all asana tasks which are non completed
		$asanaTasks = AsanaTask::where('completed', '=', false)->get();

		foreach ($asanaTasks as $asanaTask) {
			$taskData = $asanaApi->getOneTask($asanaTask->id);
			if ( !$taskData['completed'] ) continue;

			File::append('completed_list.txt', $asanaTask->id . '\n');
		}
		// find those in asana which should be completed

		// add to list and print
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
