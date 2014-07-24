<?php

class StaffCompanyData extends \Eloquent {

	protected $table = 'staff_company_data';

	protected $fillable = array(
		'user_id', 
		'employment_nr', 
		'clearing_nr', 
		'bank',
		'bank_nr' 
	);

	public function user()
	{
		return $this->belongsTo('User');
	}


}