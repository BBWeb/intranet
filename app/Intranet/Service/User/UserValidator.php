<?php namespace Intranet\Service\User;

use Intranet\Service\Validation\AbstractLaravelValidator;

abstract class UserValidator extends AbstractLaravelValidator {

	protected $baseRules = array(
		'email'=> 'required|email|unique:users',
		'name' => 'required|alpha',
		'password' => 'required|min:6|confirmed'
	);

}