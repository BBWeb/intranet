<?php namespace Intranet\Service\User;

use Intranet\Service\Validation\AbstractLaravelValidator;

class UserPaymentValidator extends AbstractLaravelValidator {

	protected function rules()
	{
		// return an array with rules	
		return array(
			'start_date' => 'required|after:' . date('Y-m-d', strtotime('-1 days')),
			'hourly_salary' => 'required|integer',
			'income_tax' => 'sometimes|numeric', 
			'employer_fee' => 'sometimes|numeric'
		);
	}	

} 