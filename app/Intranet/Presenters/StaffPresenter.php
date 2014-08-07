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

	private function getCompanyData($property)
	{
		$companydata = $this->resource->companydata;

		if ( !$companydata )
		{
			return "";
		}

		return $companydata->$property;
	}

	public function employmentNr()
	{
		return $this->getCompanyData('employment_nr');
	}

	public function clearingNr()
	{
		return $this->getCompanyData('clearing_nr');
	}

	public function bank()
	{
		return $this->getCompanyData('bank');
	}

	public function bankNr()
	{
		return $this->getCompanyData('bank_nr');
	}

	public function getCurrentPaymentInfo($property)
	{
		$activePaymentInfo = $this->resource->getActivePaymentInfo();

		if ( !$activePaymentInfo )
		{
			return "";
		}

		return $activePaymentInfo->$property;	
	}

	public function currentHourlySalary()
	{
		return $this->getCurrentPaymentInfo('hourly_salary');
	}

	public function currentEmployerFee()
	{
		return $this->getCurrentPaymentInfo('employer_fee');
	}

	public function currentIncomeTax()
	{
		return $this->getCurrentPaymentInfo('income_tax');
	}

	public function currentStartDate()
	{
		return $this->getCurrentPaymentInfo('start_date');
	}

}