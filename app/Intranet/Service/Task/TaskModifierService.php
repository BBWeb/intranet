<?php namespace Intranet\Service\Task;

use \Task;
use \ModifiedNameTask;
use \modifiedDateTask;

class TaskModifierService {

	private $task;
	private $modifiedNameTask;
	private $modifiedDateTask;

	public function __construct(Task $task, ModifiedNameTask $modifiedNameTask, modifiedDateTask $modifiedDateTask)
	{
		$this->task = $task;
		$this->modifiedNameTask = $modifiedNameTask;
		$this->modifiedDateTask = $modifiedDateTask;
	}

	public function modifyTask($id, $attributes)
	{
		$task = $this->task->find( $id );	

		if ( array_key_exists('title', $attributes) )
		{
			$newAttributes = array( 'task_id' => $id, 'modified_title' => $attributes['title'] );

			$modifiedNameTask = $task->modifiedTaskName;

			if ( $modifiedNameTask )
			{
				$modifiedNameTask->update( $newAttributes );
			}
			else 
			{
				$this->modifiedNameTask->create( $newAttributes );	
			}
		}

		// create modified task with id
		if ( array_key_exists('date', $attributes) )
		{
			$newAttributes = [ 'task_id' => $id, 'modified_date' => $attributes['date'] ];

			$modifiedDateTask = $task->modifiedTaskDate;

			if ( $modifiedDateTask )
			{
				$modifiedDateTask->update( $newAttributes );
			}
			else
			{
				$this->modifiedDateTask->create( $newAttributes );
			}
		}

	}

}