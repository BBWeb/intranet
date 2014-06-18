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

		$this->assertReponseOk();
	}

	
}