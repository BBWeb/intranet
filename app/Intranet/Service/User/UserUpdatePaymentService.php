<?php namespace Intranet\Service\User;

use Intranet\Service\Validation\ValidableInterface;

class UserUpdatePaymentService {

	protected $validator;

	private $staffPaymentData;

	public function __construct(ValidableInterface $validator, \StaffPaymentData $staffPaymentData)
	{
		$this->validator = $validator;

		$this->staffPaymentData = $staffPaymentData;
	}

	public function update(array $attributes)
	{
		if ( !$this->valid( $attributes ) )
		{
			return false;
		}

		// a user can have several payments, but should only have one at a special start date
		$staffPaymentData = $this->staffPaymentData->firstOrCreate([ 
			'user_id' => $attributes['user_id'], 
			'start_date' => $attributes['start_date'] 
		]);
		$staffPaymentData->update( $attributes);

		return true;
	}

	public function errors()
	{
		return $this->validator->errors();
	}

	protected function valid(array $attributes)
	{
		return $this->validator->with( $attributes )->passes();
	}

	
}