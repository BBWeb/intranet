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

		$user->password = Hash::make( Input::get('password') );
		if ( Input::has('admin') )
		{
			$user->admin = true;
		}

		$user->save();

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

		$user->password = Hash::make( Input::get('password') );

		$user->save();

		return Redirect::to('/staff');
	}

	public function destroy($id)
	{
		User::destroy($id);
	}

}