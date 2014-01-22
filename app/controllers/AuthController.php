<?php

class AuthController extends BaseController {

	public function getLogin()
	{
		return View::make('login');
	}

	public function postLogin() {
		$userCredentials = Input::only('email', 'password');

		if ( Auth::attempt( $userCredentials ) ) {
			return Redirect::intended('/');
		}
		return Redirect::to('/')->with('message', 'Your username/password combination was incorrect')->withInput();
	}

   public function getLogout()
   {
      Auth::logout();

      return Redirect::to('login');
   }


}
