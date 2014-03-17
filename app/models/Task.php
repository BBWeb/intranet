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
}
