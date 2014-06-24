<?php namespace Intranet\Service\User;

use Intranet\Service\Validation\ValidableInterface;
use Intranet\Service\User\UserValidator;
use Intranet\Repositories\User\UserInterface;
use Illuminate\Support\Facades\Hash;

class UserUpdateService {

	protected $validator;

	private $user;

	public function __construct(ValidableInterface $validator, \User $user)
	{
		$this->validator = $validator;

		$this->user = $user;
	}

	public function update(array $attributes)
	{
		if ( !$this->valid( $attributes ) )
		{
			return false;
		}

		if ( array_key_exists('password', $attributes) ) 
		{
			$attributes['password'] = Hash::make( $attributes['password'] );
		}

		$user = $this->user->find( $attributes['id'] ); 
		$user->save( $attributes );
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