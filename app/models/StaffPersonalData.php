<?php

class StaffPersonalData extends \Eloquent {

	protected $table = 'staff_personal_data';

	protected $fillable = array(
		'user_id', 
		'ssn', 
		'address', 
		'postal_code', 
		'city', 
		'tel'
	);

	public function user()
	{
		return $this->belongsTo('User');
	}


}