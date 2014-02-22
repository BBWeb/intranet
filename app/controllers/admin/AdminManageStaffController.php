<?php 

class AdminManageStaffController extends BaseController {

	public function index()
	{
		$users = User::all();

		return View::make('admin.manage-staff')->with('staff', $users);
	}

	public function create()
	{
		return View::make('admin.new-staff');
	}

	public function store()
	{
		$user = new User();

		$user->email = Input::get('email');
      $user->name = Input::get('name');
		$user->password = Input::get('password');
      $user->password_confirmation = Input::get('password');

		if ( Input::has('admin') ) $user->admin = true;
      
      if ( !$user->save() ) return Redirect::to('/staff/create')->with('errors', $user->errors()->all());

		return Redirect::to('/staff');
	}

	public function edit($id)
	{
		$user = User::find( $id );

		return View::make('admin.edit-staff')->with('staff', $user);
	}

	public function update($id)
	{
		$user = User::find( $id );
      
      $password = Input::get('password');
		$user->password = $password;
      $user->password_confirmation = $password;

		$user->save();

		return Redirect::to('/staff');
	}

	public function destroy($id)
	{
		User::destroy($id);
	}

}
