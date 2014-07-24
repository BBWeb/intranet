<?php namespace Intranet\Service\User;

class UserUpdateCompanyService {

	private $staffCompanyData;

	public function __construct(\StaffCompanyData $staffCompanyData)
	{
		$this->staffCompanyData = $staffCompanyData;
	}

	public function update(array $attributes)
	{
		$staffCompanyData = $this->staffCompanyData->firstOrCreate([ 'user_id' => $attributes['user_id'] ]);
		$staffCompanyData->update( $attributes);
	}
}