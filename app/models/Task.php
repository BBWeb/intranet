<?php

class Task extends Eloquent {

   public static $rules = array(
      'time_worked' => 'integer|min:0'
   );

   public function user()
   {
      return $this->belongsTo('User');
   }

   public function notreported()
   {
   		return $query->where('status', '=', 'notreported');
   }
}
