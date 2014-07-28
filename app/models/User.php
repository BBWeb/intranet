<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends \Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

   protected $fillable = array('email', 'name', 'password', 'admin');

   public $presenter = 'Intranet\Presenters\StaffPresenter';

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

   public function getRememberToken()
   {
      return $this->remember_token;
   }

   public function setRememberToken($value)
   {
      $this->remember_token = $value;
   }

   public function getRememberTokenName()
   {
      return 'remember_token';
   }

   public function tasks()
   {
      return $this->hasMany('Task');
   }

   public function personaldata()
   {
      return $this->hasOne('StaffPersonalData');
   }

   public function companydata()
   {
      return $this->hasOne('StaffCompanyData');
   }

   public function paymentdata()
   {
      return $this->hasMany('StaffPaymentData');
   }

   public function getOldPaymentInfo()
   {
      $currentDate = date('Y-m-d');

      // same as in getActivePaymentInfo but remove the first result which should be active
      // take 9999 because an offset must be used with skip
      $paymentdata = $this->paymentdata()->where('start_date', '<=', $currentDate) 
                     ->orderBy('start_date', 'desc')->skip(1)->take(9999);   

      return $paymentdata->get();
   }

   public function getActivePaymentInfo()
   {
      $currentDate = date('Y-m-d');

      // query to get the one active where startDate <= currentDate, the one with the most recent start_date should be the active one
      $paymentdata = $this->paymentdata()->where('start_date', '<=', $currentDate)->orderBy('start_date', 'desc');   
      
      return $paymentdata->first();
   }

   public function getFuturePaymentInfo()
   {
      $currentDate = date('Y-m-d');

      $paymentdata = $this->paymentdata()->where('start_date', '>', $currentDate)->orderBy('start_date', 'asc');

      return $paymentdata->get();
   }

   public function notreportedTasks()
   {
      return $this->tasks()->whereStatus('notreported')->orderBy('created_at', 'DESC');
   }

   public function notreportedTasksFor($project)
   {
      return $this->tasks()
             ->whereStatus('notreported')
             ->where('project_id', '=', $project)  
             ->orderBy('created_at', 'DESC');
   }

   public function payedTasks()
   {
      $tasks = $this->hasMany('Task')->with('subreports')->get();

      foreach ($tasks as $key => $task) {
         $payedSubreports = $task->payedSubreports;

         // if there are no payed subreports for this task, remove
         if ( $payedSubreports->isEmpty() ) unset( $tasks[$key] );
      }

      return $tasks;
   }

   public function unpayedTasks()
   {
   		// load subreprots aswell
   		$tasks = $this->hasMany('Task')->with('subreports')->get();

   		foreach ($tasks as $key => $task) {
   			$unpayedSubreports = $task->unpayedSubreports;

   			// if there are unpayed subreports, continue
   			if ( !$unpayedSubreports->isEmpty() ) continue;
   			// no unpayed subreports, remove from array
   			unset( $tasks[$key] );
   		}

   		return $tasks;
   }

   public function unpayedTasksBetween($fromDate, $toDate)
   {
      // get tasks that have subreports between dates
   		// get subreports which has been created between dates..
      $tasks = $this->hasMany('Task')->with('subreports')->get();

      foreach ($tasks as $key => $task) {
        $unpayedSubreports = $task->unpayedSubreportsBetween($fromDate, $toDate);

        // no unpayed subreports, remove tasks
        if ( $unpayedSubreports->isEmpty() ) unset( $tasks[$key] );
      }

      return $tasks;
   }

}
