<?php

class AdminManageStaffControllerTest extends TestCase {

	public function setUp()
	{
		parent::setUp();
		$this->mock = Mockery::mock('Eloquent', 'User');
	}

	public function tearDown()
	{
		Mockery::close();
	}

	public function testIndex()
	{
		Auth::shouldReceive('user')->andReturn($user = Mockery::mock('StdClass'));
		$user->admin = false;

		$this->mock
			 ->shouldReceive('all')
			 ->andReturn( array() );

		$this->app->instance('User', $this->mock);

		$this->call('GET', '/staff');

		$this->assertViewHas('staff');
	}

	public function testCreate()
	{
		Auth::shouldReceive('user')->andReturn($user = Mockery::mock('StdClass'));
		$user->admin = false;
		
		$this->call('GET', '/staff/create');

		$this->assertResponseOk();
	}

	public function testEdit()
	{
		Auth::shouldReceive('user')->andReturn($user = Mockery::mock('StdClass'));
		$user->admin = false;

		$this->mock
			 ->shouldReceive('find')	
			 ->once()
			 ->andReturn( $user );

		$user->id = 1;
		$user->name = 'Niklas';
		$user->email = 'niklas@bbweb.se';

		$this->app->instance('User', $this->mock);

		$this->call('GET', '/staff/1/edit');

		$this->assertResponseOk();
	}

	public function testStoreSuccess()
	{
		// set up mocks
		Auth::shouldReceive('user')->andReturn($user = Mockery::mock('StdClass'));
		$user->admin = true;

		$userCreatorMock = Mockery::mock('Intranet\Service\User\UserCreatorService');

	 	// gather input etc
		$userCreatorMock
			 ->shouldReceive('save')
			 ->once()
			 ->andReturn( true );

		$this->app->instance('Intranet\Service\User\UserCreatorService', $userCreatorMock);

		$this->call('POST', '/staff');
		// mock dependency
		$this->assertRedirectedTo('/staff');
	}

	public function testStoreFail()
	{
		// set up mocks
		Auth::shouldReceive('user')->andReturn($user = Mockery::mock('StdClass'));
		$user->admin = true;

		$userCreatorMock = Mockery::mock('Intranet\Service\User\UserCreatorService');

	 	// gather input etc
		$userCreatorMock
			 ->shouldReceive('save')
			 ->once()
			 ->andReturn( false );

		$userCreatorMock
			 ->shouldReceive('errors')
			 ->once()
			 ->andReturn( array() );

		$this->app->instance('Intranet\Service\User\UserCreatorService', $userCreatorMock);

		$this->call('POST', '/staff');
		// mock dependency
		$this->assertRedirectedTo('/staff/create');
		$this->assertSessionHasErrors();
	}

	/*
	public function testUpdate()
	{
		Auth::shouldReceive('user')->andReturn($user = Mockery::mock('StdClass'));
		$user->admin = false;

		$this->mock
			 ->shouldReceive('find')	
			 ->once()
			 ->andReturn( $user );

		$user->id = 1;
		$user->name = 'Niklas';
		$user->email = 'niklas@bbweb.se';

		$this->app->instance('User', $this->mock);

		$this->call('PUT', '/staff/1');

		$this->assertReponseOk();
	}
	*/
	
}