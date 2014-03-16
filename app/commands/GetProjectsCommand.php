<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Intranet\Handlers\AsanaHandler;

class GetProjectsCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'command:getprojects';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Get projects from asana and stores in projects table.';

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
		$apikey = $this->argument('apikey');
		$asana = new AsanaHandler($apikey);

		$asanaProjects = $asana->getProjects();
		foreach ($asanaProjects as $asanaProject) {
			$project = new Project();

			$project->id = $asanaProject->id;
			$project->name = $asanaProject->name;

			$project->save();
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
			array('apikey', InputArgument::REQUIRED, 'Apikey for asana.')		);
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
