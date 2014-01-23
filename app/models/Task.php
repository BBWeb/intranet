<?php

class Task extends Eloquent {

   public function user()
   {
      return $this->belongsTo('User');
   }

   public function notreported()
   {
   		return $query->where('status', '=', 'notreported');
   }
}
