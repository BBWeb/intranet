<?php namespace Intranet\Service\User;

class UserCreateValidator extends UserValidator {

	protected function rules()
	{
		return $this->baseRules;
	}	
}