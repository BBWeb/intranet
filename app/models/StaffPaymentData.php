<?php

class StaffPaymentData extends \Eloquent {

	protected $table = 'staff_payment_data';

	protected $fillable = array(
		'user_id',
		'income_tax',
		'employer_fee',
		'hourly_salary',
		'start_date'
	);

	public function user()
	{
		return $this->belongsTo('User');
	}
}