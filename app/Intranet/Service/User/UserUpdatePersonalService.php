<?php namespace Intranet\Service\User;

class UserUpdatePersonalService {

	private $staffPersonal;

	public function __construct(\StaffPersonalData $staffPersonal)
	{
		$this->staffPersonal = $staffPersonal;
	}

	public function update(array $attributes)
	{
		$staffPersonal = $this->staffPersonal->firstOrCreate([ 'user_id' => $attributes['user_id'] ]);
		$staffPersonal->update( $attributes);
	}
}