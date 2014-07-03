<?php

class Task extends Eloquent {

   protected $fillable = array('user_id', 'asana_id', 'project_id', 'task');

   public static $rules = array(
      'time_worked' => 'integer|min:0'
   );

   public function validate()
   {
      $validator = Validator::make($this->attributes, static::$rules);

      return $validator->passes();
   }

   public function user()
   {
      return $this->belongsTo('User');
   }

   public function theproject()
   {
      return $this->belongsTo('Project', 'project_id', 'id');
   }

   public function notreported()
   {
   		return $query->where('status', '=', 'notreported');
   }

   public function modifiedNameIfAny()
   {
      $title = $this->task;

      $modifiedNameTask = $this->modifiedTaskName;

      if ( $modifiedNameTask )
      {
         $title = $modifiedNameTask->modified_title;
      }

      return $title;
   }

   public function modifiedDateIfAny()
   {
      $date = $this->reported_date;

      $modifiedDateTask = $this->modifiedTaskDate;

      if ( $modifiedDateTask )
      {
         $date = $modifiedDateTask->modified_date;
      }

      return $date;
   }

   public function modifiedTaskDate()
   {
      return $this->hasOne('ModifiedDateTask');
   }

   public function modifiedTaskName()
   {
      return $this->hasOne('ModifiedNameTask');
   }

   public function subreports()
   {
      return $this->hasMany('Subreport');
   }

   public function payedSubreports()
   {
      return $this->hasMany('Subreport')->wherePayed(true);
   }

   public function unpayedSubreports()
   {
      return $this->hasMany('Subreport')->wherePayed(false);
   }

   public function unpayedSubreportsBetween($fromDate, $toDate)
   {
      $subreports = $this->hasMany('Subreport')->wherePayed(false)
                     ->whereBetween('reported_date', array( $fromDate, $toDate ))
                     ->get();

      return $subreports;
   }

   public function payUnpayedSubreports()
   {
      $unpayedSubreports = $this->hasMany('Subreport')->wherePayed(false)->get();

      foreach ($unpayedSubreports as $unpayedSubreport) {
         $unpayedSubreport->payed = true;
         $unpayedSubreport->save();
      }
   }

   public function unpayedTimeToday()
   {
      $todaysDate = date('Y-m-d');

      $subreport = $this->hasMany('Subreport')->whereReportedDate($todaysDate)->wherePayed(false)->first();

      $timeWorkedToday = 0;

      if ( $subreport ) $timeWorkedToday = $subreport->time;

      return $timeWorkedToday;
   }

   public function timeToday()
   {
      $todaysDate = date('Y-m-d');

      $subreport = $this->hasMany('Subreport')->whereReportedDate($todaysDate)->first();

      $timeWorkedToday = 0;

      if ( $subreport ) $timeWorkedToday = $subreport->time;

      return $timeWorkedToday;
   }

   public function totalPayedTime()
   {
      $subReports = $this->hasMany('Subreport')->wherePayed(true)->get();

      $totalTime = 0;
      foreach ($subReports as $subReport) {
         $totalTime += $subReport->time;
      }

      return $totalTime;
   }

   public function totalUnpayedTime()
   {
      // get subreports and calculate
      $subReports = $this->hasMany('Subreport')->wherePayed(false)->get();

      $totalTime = 0;
      foreach ($subReports as $subReport) {
         $totalTime += $subReport->time;
      }

      return $totalTime;
   }


   public function totalUnpayedTimeBetween($from, $to)
   {
      // get subreports and calculate
      $subReports = $this->hasMany('Subreport')->wherePayed(false)->whereBetween('reported_date', array($from, $to))->get();

      $totalTime = 0;
      foreach ($subReports as $subReport) {
         $totalTime += $subReport->time;
      }

      return $totalTime;
   }

   public function totaltime()
   {
      // get subreports and calculate
      $subReports = $this->hasMany('Subreport')->get();

      $totalTime = 0;
      foreach ($subReports as $subReport) {
         $totalTime += $subReport->time;
      }

      return $totalTime;
   }
}
