<?php

class ChangesControllerTest extends TestCase {

	public function setUp()
	{
		parent::setUp();
		$this->mock = Mockery::mock('Eloquent', 'Project');
	}

	public function testGetIndex()
	{		
		Auth::shouldReceive('user')->andReturn($user = Mockery::mock('StdClass'));
		$user->admin = true;

		$this->call('GET', 'changes');

		$this->assertResponseOk();
		$this->assertViewHas('projects');
	}

	public function testPostIndex()
	{
		$this->call('POST', 'changes', array('project' => 1));
		
		$this->assertRedirectedTo('changes/1');
	}

	public function testGetProject()
	{

		$this->call('GET', 'changes/1');

		$this->assertResponseOk();
		$this->assertViewHas('tasks');	
	}
}