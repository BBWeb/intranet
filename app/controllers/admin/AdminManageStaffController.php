<?php

use Intranet\Service\User\UserCreatorService;
use Intranet\Service\User\UserUpdateService;
use Intranet\Service\User\UserUpdatePersonalService;
use Intranet\Service\User\UserUpdateCompanyService;
use Intranet\Service\User\UserUpdatePaymentService;

class AdminManageStaffController extends BaseController {

	private $user;
	private $userCreator;
	private $userUpdateService;
	private $userUpdatePersonalService;
	private $userUpdateCompanyService;
	private $userUpdatePaymentService;

	public function __construct(
		User $user, 
		UserCreatorService $userCreator, 
		UserUpdateService $userUpdateService, 
		UserUpdatePersonalService $userUpdatePersonalService,
		UserUpdateCompanyService $userUpdateCompanyService,
		UserUpdatePaymentService $userUpdatePaymentService
	)
	{
		$this->user = $user;
		$this->userCreator = $userCreator;
		$this->userUpdateService = $userUpdateService;
		$this->userUpdatePersonalService = $userUpdatePersonalService;
		$this->userUpdateCompanyService = $userUpdateCompanyService;
		$this->userUpdatePaymentService = $userUpdatePaymentService;
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

	public function updatepersonal($id)
	{
		$user = $this->user->find($id);

		$this->userUpdatePersonalService->update( ['user_id' => $user->id ] + Input::all() );

		// redirect back to view
		return Redirect::back();
	}

	public function company($id)
	{
		$user = $this->user->find($id);

		return View::make('admin.staff.company')->with('staff', $user);
	}

	public function updatecompany($id)
	{
		$user = $this->user->find($id);			

		$this->userUpdateCompanyService->update( ['user_id' => $user->id ] + Input::all() );

		return Redirect::back();
	}

	public function payment($id)
	{
		$user = $this->user->find($id);

		return View::make('admin.staff.payment')->with('staff', $user);
	}

	public function updatepayment($id)
	{
		$user = $this->user->find($id);

		$updateSuccess = $this->userUpdatePaymentService->update( ['user_id' => $user->id ] + Input::all() );

		if ( $updateSuccess )
		{
			return Response::json(['success' => true]);
		}
		else 
		{
			return Response::json(['errors' => $this->userUpdatePaymentService->errors()->toJson() ]);	
		}
	}

	public function removepayment($userId, $id)
	{
		// the id should be unique for payment, so userId is not needed at this time
		$staffPaymentData = StaffPaymentData::find($id);

		$deleted = $staffPaymentData->delete();

		return Response::json(['deleted' => $deleted ]);
	}

}
