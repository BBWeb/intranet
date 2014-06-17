<?php 

class AuthControllerTest extends TestCase {

	public function testGetLogin()
	{
		$this->call('GET', 'login');

		$this->assertResponseOk();
	}

	public function testPostLoginSuccess()
	{
		Auth::shouldReceive('attempt')->andReturn(true);

		$this->call('POST', 'login');	

		$this->assertRedirectedTo('/');
	}

	public function testPostLoginFail()
	{
		Auth::shouldReceive('attempt')->andReturn(false);

		$this->call('POST', 'login');	

		$this->assertRedirectedTo('login');
	}

}
