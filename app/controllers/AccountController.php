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

      $user->save();

      return Redirect::to('account'); 
   }
   
}
