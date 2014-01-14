<?php

class AccountController extends BaseController {

	public function getIndex()
	{
		return View::make('user.account');
	}
   
}
