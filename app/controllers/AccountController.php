<?php

class AccountController extends BaseController {

	public function getIndex()
	{
		return View::make('user.account');
	}

	public function postIndex() {
		$userCredentials = Input::only('email', 'password');

		if ( Auth::attempt( $userCredentials ) ) {
			return Redirect::intended('/');
		}
		return Redirect::to('/')->with('message', 'Your username/password combination was incorrect')->withInput();
	}

}