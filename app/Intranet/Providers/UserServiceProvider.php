<?php namespace Intranet\Providers;

use Illuminate\Support\ServiceProvider;

use Intranet\Service\User\UserCreatorService;
use Intranet\Service\User\UserCreateValidator;

use Intranet\Service\User\UserUpdateService;
use Intranet\Service\User\UserUpdateValidator;

use Intranet\Service\User\UserUpdatePersonalService;
use Intranet\Service\User\UserUpdateCompanyService;


use Intranet\Service\User\UserUpdatePaymentService;
use Intranet\Service\User\UserPaymentValidator;

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

		$app->bind('Intranet\Service\User\UserUpdatePersonalService', function($app)
		{
			return new UserUpdatePersonalService(
				$app->make('StaffPersonalData')
			);
		});

		$app->bind('Intranet\Service\User\UserUpdateCompanyService', function($app)
		{
			return new UserUpdateCompanyService(
				$app->make('StaffCompanyData')
			);
		});

		$app->bind('Intranet\Service\User\UserUpdatePaymentService', function($app)
		{
			return new UserUpdatePaymentService(
				new UserPaymentValidator( $app['validator'] ),
				$app->make('StaffPaymentData')
			);
		});
	}
}