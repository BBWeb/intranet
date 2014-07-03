<?php namespace Intranet\Service\User;

class UserUpdateValidator extends UserValidator {

	protected function rules()
	{
		return array(
			'password' => $this->baseRules['password']
		);
	}
}