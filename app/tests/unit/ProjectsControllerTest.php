<?php

class ProjectsControllerTest extends TestCase {

	public function __construct()
	{
	}

	public function tearDown()
	{
		Mockery::close();
	}

	public function testGetIndex()
	{
		Auth::shouldReceive('user')->andReturn($user = Mockery::mock('StdClass'));

		$user->notreportedTasks = array();
		$user->admin = false;

		$this->call('GET', '/');
		
		$this->assertViewHas('tasks');	
	}
}