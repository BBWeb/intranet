<?php

return array(
	'default' => 'mysql',

	'connections' => array(
		'sqlite' => array(
			'driver' => 'sqlite',
			'database' => ':memory:',
			'prefix' => ''
		),
		'mysql' => array(
			'driver'    => 'mysql',
			'host'      => 'localhost',
			'database'  => 'test-database',
			'username'  => 'homestead',
			'password'  => 'secret',
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
		),

	)
);