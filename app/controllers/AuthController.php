<?php

class AuthController extends BaseController {

	public function getLogin()
	{
		return View::make('login');
	}

	public function postLogin() {
		$userCredentials = Input::only('email', 'password');
		$remember = Input::has('remember-me');

		if ( Auth::attempt( $userCredentials, $remember ) ) {
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
