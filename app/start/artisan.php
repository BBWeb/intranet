<?php

/*
|--------------------------------------------------------------------------
| Register The Artisan Commands
|--------------------------------------------------------------------------
|
| Each available Artisan command must be registered with the console so
| that it is available to be called. We'll register every command so
| the console gets access to each of the command object instances.
|
*/
Artisan::add(new CacheAsanaCommand);
Artisan::add(new GetProjectsCommand);
Artisan::add(new UpdateTaskRefToProjectsCommand);
Artisan::add(new MoveReportedTimeAndDateToTimeReport);
Artisan::add(new UpdateAsanaTasks);
Artisan::add(new RemoveDeletedAsanaTasks);
Artisan::add(new MigrateToNewDb);
Artisan::add(new MigrateLastqueryCacheToDb);
Artisan::add(new CheckAsanaCompleteness);
