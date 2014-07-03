<?php

class AdminReportedTimeControllerTest extends TestCase {

	public function setUp()
	{
		parent::setUp();
		$this->mock = Mockery::mock('Eloquent', 'User');
	}	

	public function testGetIndex()
	{
		Auth::shouldReceive('user')->andReturn($user = Mockery::mock('StdClass'));
		$user->admin = false;

		$this->call('GET', '/staff-report');

		$this->assertResponseOk();
		$this->assertViewHas('users');
	}

	public function testGetTimeReport()
	{
		Auth::shouldReceive('user')->andReturn($user = Mockery::mock('StdClass'));
		$user->admin = false;

		$this->mock
		     ->shouldReceive('lists')
		     ->andReturn( array() );

		$this->mock
			 ->shouldReceive('find')
			 ->andReturn( $user );

		$unpayedTask = Mockery::mock('StdClass');
		$unpayedTask->id = 1;
		$unpayedTask->shouldReceive('totalUnpayedTimeBetween')
					->andReturn( 1 );

		$user->shouldReceive('unpayedTasksBetween')
			 ->andReturn( array() );

		$unpayedTask = Mockery::mock('StdClass');
		$unpayedTask->shouldReceive('totalUnpayedTimeBetween')
					->andReturn( 1 );

		$this->app->instance('User', $this->mock);

		$this->call('GET', '/staff-report/1/01-06-2014/19-06-2014');

		$this->assertViewHas('users');
		$this->assertViewHas('tasks');
		$this->assertViewHas('from');
		$this->assertViewHas('to');
		$this->assertViewHas('totaltime');
	}

	public function tearDown()
	{
		Mockery::close();
	}
}