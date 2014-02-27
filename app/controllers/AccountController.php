<?php

class AccountController extends BaseController {

	public function getIndex()
	{
		return View::make('user.account');
	}

   public function postUpdateApikey()
   {
      $apiKey = Input::get('api-key');

      $user = Auth::user();

      $user->api_key = $apiKey;

      if ( !$user->forceSave() ) return Redirect::to('account')->with('errors', $user->errors()->all());

      return Redirect::to('account');
   }

   public function postUpdatePassword()
   {
      $user = Auth::user();

      $user->password = Input::get('password');
      $user->password_confirmation = Input::get('password_confirmation');

      $user->updateUniques();

      return Redirect::to('account');
   }
}
