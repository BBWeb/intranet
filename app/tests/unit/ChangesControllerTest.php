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
	
	/* TODO FIX - illegal offset error etc
	public function testGetProject()
	{
		$this->mock->shouldReceive('lists')->andReturn(array());
		$this->mock->shouldReceive('find')->andReturn($project = Mockery::mock('StdClass'));
		$project->shouldReceive('orderedTasks')->andReturn(array());
		$this->app->bind('Project', $this->mock);
		$this->call('GET', 'changes/1');
		$this->assertResponseOk();
		$this->assertViewHas('projects');
		$this->assertViewHas('project');
	}
	*/
}