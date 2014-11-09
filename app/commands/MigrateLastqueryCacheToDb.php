<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MigrateLastqueryCacheToDb extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'command:migratecachetodb';

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

		foreach ($users as $user)
		{
			$lastQueryTime = Cache::get('users:' . $user->id . ':lastquery');

			if (!$lastQueryTime) continue;

			LastQueryCache::create([
				'user_id' => $user->id,
				'time' => $lastQueryTime
			]);
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
