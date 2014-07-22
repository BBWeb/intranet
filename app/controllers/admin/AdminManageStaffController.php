<?php

use Intranet\Service\User\UserCreatorService;
use Intranet\Service\User\UserUpdateService;

class AdminManageStaffController extends BaseController {

	private $user;
	private $userCreator;
	private $userUpdateService;

	public function __construct(User $user, UserCreatorService $userCreator, UserUpdateService $userUpdateService)
	{
		$this->user = $user;
		$this->userCreator = $userCreator;
		$this->userUpdateService = $userUpdateService;
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
		$user = $this->userCreator->save(array(
			'email' => Input::get('email'),
			'name' => Input::get('name'),
			'password' => Input::get('password'),
			'password_confirmation' => Input::get('password'),
			'admin' => Input::has('admin')
		));

	    if ( !$user ) 
	    {
	    	return Redirect::to('/staff/create')
	    			->withErrors( $this->userCreator->errors() )
	    			->withInput();
	    }

		return Redirect::to('/staff');
	}

	public function edit($id)
	{
		$user = $this->user->find( $id );

		return View::make('admin.staff.account')->with('staff', $user);
	}

	public function update($id)
	{
    $password = Input::get('password');

		$input = array(
			'id' => $id,
			'password' => $password,
			'password_confirmation' => $password,
			'admin' => Input::has('admin')
		);

		if ( !$this->userUpdateService->update( $input ) )  {
			return Redirect::to('/staff/' . $id . '/edit')->withErrors( $this->userUpdateService->errors() );
		}

		return Redirect::to('/staff');
	}

	public function destroy($id)
	{
		$this->user->destroy($id);
	}

	public function personal($id)
	{
		$user = $this->user->find($id);

		return View::make('admin.staff.personal')->with('staff', $user);
	}

	public function company($id)
	{
		$user = $this->user->find($id);

		return View::make('admin.staff.company')->with('staff', $user);
	}

}
