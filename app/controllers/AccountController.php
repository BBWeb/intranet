<?php

use Intranet\Service\User\UserUpdateService;

class AccountController extends BaseController {

   private $userUpdateService;

   public function __construct(UserUpdateService $userUpdateService)
   {
      $this->userUpdateService = $userUpdateService;
   }

	public function getIndex()
	{
		return View::make('user.account');
	}

   public function postUpdateApikey()
   {
      $apiKey = Input::get('api-key');

      $user = Auth::user();

      $user->api_key = $apiKey;

      $user->update();

      return Redirect::to('account');
   }

   public function postUpdatePassword()
   {
      $user = Auth::user();

      $user->password = Input::get('password');
      $user->password_confirmation = Input::get('password_confirmation');

      $input = array_merge( Input::all(), array('id' => $user->id) );

      $updateSuccess = $this->userUpdateService->update( $input );

      if ( !$updateSuccess ) {
         return Redirect::to('/account')->withErrors( $this->userUpdateService->errors() );
      }

      return Redirect::to('/account')->with('message', 'Lösenord uppdaterat!');
   }
}
