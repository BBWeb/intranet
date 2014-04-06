<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use LaravelBook\Ardent\Ardent;

class User extends Ardent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

   	public static $rules = array(
      'email' => 'required|email|unique:users',
      'password' => 'required|min:6|confirmed',
      'password_confirmation' => 'required|min:6'
   );

   public $autoPurgeRedundantAttributes = true;

   public function beforeSave()
   {
      if ( $this->isDirty('password') ) {
         $this->password = Hash::make($this->password);
      }
   }
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

   public function tasks()
   {
      return $this->hasMany('Task');
   }

   public function unpayedTasks()
   {
   		$tasks = $this->hasMany('Task')->get();

   		foreach ($tasks as $key => $task) {
   			$unpayedSubreports = $task->unpayedSubreports;

   			// if there are unpayed subreports, continue
   			if ( !$unpayedSubreports->isEmpty() ) continue;
   			// no unpayed subreports, remove from array
   			unset( $tasks[$key] );
   		}

   		return $tasks;
   }

}
