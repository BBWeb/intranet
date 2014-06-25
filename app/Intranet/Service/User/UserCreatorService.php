<?php namespace Intranet\Service\User;

use Intranet\Service\Validation\ValidableInterface;
use Intranet\Service\User\UserValidator;
use Intranet\Repositories\User\UserInterface;
use Illuminate\Support\Facades\Hash;

class UserCreatorService {

	protected $validator;

	private $user;

	public function __construct(ValidableInterface $validator, \User $user)
	{
		$this->validator = $validator;

		$this->user = $user;
	}

	public function save(array $attributes)
	{
		if ( !$this->valid( $attributes ) )
		{
			return false;
		}

		if ( array_key_exists('password', $attributes) ) 
		{
			$attributes['password'] = Hash::make( $attributes['password'] );
		}

		return $this->user->create( $attributes );
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