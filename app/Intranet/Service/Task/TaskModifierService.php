<?php namespace Intranet\Service\Task;

use \AsanaTask;
use \ModifiedNameAsanaTask;
use \ModifiedDateAsanaTask;

use Illuminate\Support\Facades\Log;

class TaskModifierService {

	private $task;
	private $modifiedNameTask;
	private $modifiedDateTask;

	public function __construct(AsanaTask $asanaTask, ModifiedNameAsanaTask $modifiedNameTask, ModifiedDateAsanaTask $modifiedDateTask)
	{
		$this->asanaTask = $asanaTask;
		$this->modifiedNameTask = $modifiedNameTask;
		$this->modifiedDateTask = $modifiedDateTask;
	}

	public function modifyTask($id, $attributes)
	{
		$asanaTask = $this->asanaTask->find( $id );

		if ( array_key_exists('title', $attributes) )
		{
			$newAttributes = array( 'asana_task_id' => $id, 'modified_title' => $attributes['title'] );

			$modifiedNameTask = $asanaTask->modifiedTaskName;

			if ( $modifiedNameTask )
			{
				$modifiedNameTask->update( $newAttributes );
			}
			else
			{
				$this->modifiedNameTask->create( $newAttributes );
			}
		}

		// create modified asanaTask with id
		if ( array_key_exists('date', $attributes) )
		{
			$newAttributes = [ 'asana_task_id' => $id, 'modified_date' => $attributes['date'] ];

			$modifiedDateTask = $asanaTask->modifiedTaskDate;

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