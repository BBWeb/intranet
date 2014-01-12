<?php

class AuthController extends BaseController {

	public function getIndex()
	{
		return View::make('user.account');
	}

}