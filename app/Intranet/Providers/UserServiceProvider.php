<?php namespace Intranet\Providers;

use Illuminate\Support\ServiceProvider;

use Intranet\Service\User\UserCreatorService;
use Intranet\Service\User\UserCreateValidator;
use Intranet\Service\User\UserUpdateService;
use Intranet\Service\User\UserUpdateValidator;

class UserServiceProvider extends ServiceProvider {

	public function register()
	{
		$app = $this->app;

		$app->bind('Intranet\Service\User\UserCreatorService', function($app)
		{
			return new UserCreatorService(
				new UserCreateValidator( $app['validator'] ),
				$app->make('User')
			);
		});

		$app->bind('Intranet\Service\User\UserUpdateService', function($app)
		{
			return new UserUpdateService(
				new UserUpdateValidator( $app['validator'] ),
				$app->make('User')
			);
		});
	}
}