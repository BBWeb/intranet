<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MigrateToNewDb extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'command:migratetonewdb';

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

		DB::statement("SET foreign_key_checks=0");
		DB::table('users')->truncate();
		DB::statement("SET foreign_key_checks=1");

		$users = DB::connection('migration')->table('users')->get();

		foreach ($users as $user)
		{
			$this->info("User email " . $user->email . " for id " . $user->id);
			$DBuser = new User();
			$DBuser->id = $user->id;
			$DBuser->email = $user->email;
			$DBuser->password = $user->password;
			$DBuser->admin = $user->admin;
			$DBuser->name = $user->name;
			$DBuser->api_key = $user->api_key;
			$DBuser->remember_token = $user->remember_token;

			$DBuser->created_at = $user->created_at;
			$DBuser->updated_at = $user->updated_at;

			$DBuser->save();
		}

		DB::table('staff_company_data')->truncate();

		$staffCompanyData = DB::connection('migration')->table('staff_company_data')->get();

		foreach ($staffCompanyData as $companyData)
		{
			$scd= new StaffCompanyData();
			$scd->id = $companyData->id;
			$scd->user_id = $companyData->user_id;
			$scd->employment_nr = $companyData->employment_nr;
			$scd->clearing_nr = $companyData->clearing_nr;
			$scd->bank = $companyData->bank;
			$scd->created_at = $companyData->created_at;
			$scd->updated_at = $companyData->updated_at;
			$scd->save();
		}

		DB::table('projects')->truncate();
		$projects = DB::connection('migration')->table('projects')->get();

		foreach ($projects as $project)
		{
			$dbProject = new Project();
			$dbProject->id = $project->id;
			$dbProject->name = $project->name;
			$dbProject->created_at = $project->created_at;
			$dbProject->updated_at = $project->updated_at;
			$dbProject->save();
		}

		DB::table('tasks')->truncate();
		DB::table('asana_tasks')->truncate();
		$tasks = DB::connection('migration')->table('tasks')->get();

		// remove the current modified date task data
		DB::table('modified_date_tasks')->truncate();
		DB::table('modified_name_tasks')->truncate();

		foreach ($tasks as $task)
		{
			$dbTask = new Task();
			$dbTask->id = $task->id;
			$dbTask->user_id = $task->user_id;
			$dbTask->asana_task_id = $task->asana_id;
			$dbTask->status = $task->status;

			$dbTask->created_at = $task->created_at;
			$dbTask->updated_at = $task->updated_at;

			$dbTask->save();

			// check if there already is an adjusted asana task for this one
			$dbAsanaTask = AsanaTask::find( $task->asana_id );

			if ($dbAsanaTask)
			{
				// append adjusted time?
				$dbAsanaTask->adjusted_time += $task->adjusted_time;
				$dbAsanaTask->save();
			}
			else
			{
				$dbAsanaTask = new AsanaTask();
				$dbAsanaTask->id = $task->asana_id;
				$dbAsanaTask->name = $task->task;
				$dbAsanaTask->adjusted_time = $task->adjusted_time;
				$dbAsanaTask->project_id = $task->project_id;
				$dbAsanaTask->completion_date = $task->reported_date;
				$dbAsanaTask->completed = $task->reported_date > '0000-00-00' ? true : false;
				$dbAsanaTask->save();
			}

			// get modified data in migration table
			$modifiedDateTask = DB::connection('migration')->table('modified_date_tasks')->where('task_id', '=', $task->id)->first();
			if ($modifiedDateTask)
			{
				$dbModifiedDateTask = new ModifiedDateAsanaTask();
				$dbModifiedDateTask->id = $modifiedDateTask->id;
				$dbModifiedDateTask->asana_task_id = $task->asana_id;
				$dbModifiedDateTask->modified_date = $modifiedDateTask->modified_date;

				$dbModifiedDateTask->updated_at = $modifiedDateTask->updated_at;
				$dbModifiedDateTask->created_at = $modifiedDateTask->created_at;

				$dbModifiedDateTask->save();
			}
			// 	asana_id in the new should be the one from task
			$modifiedNameTask = DB::connection('migration')->table('modified_name_tasks')->where('task_id', '=', $task->id)->first();
			if ($modifiedNameTask)
			{
				$dbModifiedNameTask = new ModifiedNameAsanaTask();
				$dbModifiedNameTask->id = $modifiedNameTask->id;
				$dbModifiedNameTask->asana_task_id = $task->asana_id;
				$dbModifiedNameTask->modified_title = $modifiedNameTask->modified_title;

				$dbModifiedNameTask->updated_at = $modifiedNameTask->updated_at;
				$dbModifiedNameTask->created_at = $modifiedNameTask->created_at;

				$dbModifiedNameTask->save();
			}


		}

		DB::table('subreports')->truncate();

		$subreports = DB::connection('migration')->table('subreports')->get();

		foreach ($subreports as $subreport)
		{
			// add new subreport
			$dbSubreport = new Subreport();
			$dbSubreport->id = $subreport->id;
			$dbSubreport->task_id = $subreport->task_id;
			$dbSubreport->time = $subreport->time;
			$dbSubreport->reported_date = $subreport->reported_date;
			$dbSubreport->created_at = $subreport->created_at;
			$dbSubreport->updated_at = $subreport->updated_at;
			$dbSubreport->deleted_at = $subreport->deleted_at;
			$dbSubreport->payed = $subreport->payed;
			$dbSubreport->name = 'CREATED BEFORE NAME ATTRIBUTE';
			$dbSubreport->save();
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
		);
	}

}
