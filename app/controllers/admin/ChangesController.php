<?php

class ChangesController extends \BaseController {

	public function getIndex()
	{
		return \View::make('admin.changes.base');	
	}	
}