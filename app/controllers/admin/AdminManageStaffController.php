<?php

class AdminManageStaffController extends BaseController {

	private $user;

	public function __construct($user)
	{
		$this->user = $user;
	}

	public function index()
	{
		$users = $this->user->all();

		return View::make('admin.manage-staff')->with('staff', $users);
	}

	public function create()
	{
		return View::make('admin.new-staff');
	}

	public function store()
	{
		$user = $this->user->create(array(
			'email' => Input::get('email'),
			'name' => Input::get('name'),
			'password' = Input::get('password'),
			'password_confirmation' => Input::get('password')
		));

		if ( Input::has('admin') ) $user->admin = true;

	    if ( !$user->save() ) return Redirect::to('/staff/create')->with('errors', $user->errors()->all());

		return Redirect::to('/staff');
	}

	public function edit($id)
	{
		$user = $this->user->find( $id );

		return View::make('admin.edit-staff')->with('staff', $user);
	}

	public function update($id)
	{
		$user = $this->user->find( $id );

      	$password = Input::get('password');
		$user->password = $password;
      	$user->password_confirmation = $password;

		if ( !$user->updateUniques() ) return Redirect::to('/staff/' . $id . '/edit')->with('errors', $user->errors()->all());

		return Redirect::to('/staff');
	}

	public function destroy($id)
	{
		User::destroy($id);
	}

}
