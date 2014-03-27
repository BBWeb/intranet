<?php

class Task extends Eloquent {

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

   public function subreports()
   {
      return $this->hasMany('Subreport');
   }

   public function timeToday()
   {
      $todaysDate = date('Y-m-d');

      $subreport = $this->hasMany('Subreport')->whereReportedDate($todaysDate)->first();

      $timeWorkedToday = 0;

      if ( $subreport ) $timeWorkedToday = $subreport->time;

      return $timeWorkedToday;
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
