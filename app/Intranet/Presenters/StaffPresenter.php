<?php namespace Intranet\Presenters;

use McCool\LaravelAutoPresenter\BasePresenter;

class StaffPresenter extends BasePresenter {

	public function __construct(\User $user)
	{
		$this->resource = $user;
	}

	private function getPersonalData($property)
	{
		$personaldata = $this->resource->personaldata;

		if ( !$personaldata )
		{
			return "";
		}

		return $personaldata->$property;	
	}

	public function ssn()
	{
		return $this->getPersonalData('ssn');	
	}

	public function tel()
	{
		return $this->getPersonalData('tel');
	}

	public function city()
	{
		return $this->getPersonalData('city');
	}

	public function postalCode()
	{
		return $this->getPersonalData('postal_code');
	}

	public function address()
	{
		return $this->getPersonalData('address');
	}

}