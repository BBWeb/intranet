<?php

class AccountControllerTest extends TestCase {

	public function setUp()
	{
		parent::setUp();
		$this->mock = Mockery::mock('Eloquent', 'User');
	}

	public function tearDown()
	{
		Mockery::close();
	}

	public function testGetIndex()
	{
		Auth::shouldReceive('user')->andReturn($user = Mockery::mock('StdClass'));
		$user->admin = false;

		$user->email = 'john@bbweb.se';
		$user->api_key = '1312321321';

		$this->call('GET', 'account');
		$this->assertResponseOk();
	}

	public function testPostUpdateApikey()
	{
		Auth::shouldReceive('user')->andReturn($user = Mockery::mock('StdClass'));
		$user->admin = false;

		$user->email = 'john@bbweb.se';
		$user->api_key = '1312321321';

		// assert right stuff is being called
		$user->shouldReceive('update')->andReturn( true );

		$this->call('POST', 'account/update-apikey');

		$this->assertRedirectedTo('account');
	}

	public function testPostUpdatePasswordSuccess()
	{
		Auth::shouldReceive('user')->andReturn($user = Mockery::mock('StdClass'));
		$user->admin = false;
		$user->id = 1;
		$user->email = 'john@bbweb.se';
		$user->api_key = '1312321321';

		$userUpdateServiceMock = Mockery::mock('StudyBuddy\Service\User\UserUpdateService');
		// assert right stuff is being called
		$userUpdateServiceMock
			->shouldReceive('update')
			->andReturn( true );

		$this->app->bind('StudyBuddy\Service\User\UserUpdateService', $userUpdateServiceMock);

		$this->call('POST', 'account/update-password');

		$this->assertRedirectedTo('account');
	}

	public function testPostUpdatePasswordFail()
	{
		Auth::shouldReceive('user')->andReturn($user = Mockery::mock('StdClass'));
		$user->admin = false;
		$user->id = 1;
		$user->email = 'john@bbweb.se';
		$user->api_key = '1312321321';

		$userUpdateServiceMock = Mockery::mock('StudyBuddy\Service\User\UserUpdateService');
		// assert right stuff is being called
		$userUpdateServiceMock
			->shouldReceive('update')
			->andReturn( false );

		$this->app->bind('StudyBuddy\Service\User\UserUpdateService', $userUpdateServiceMock);

		$this->call('POST', 'account/update-password');

		$this->assertRedirectedTo('account');
		$this->assertSessionHasErrors();
	}

}