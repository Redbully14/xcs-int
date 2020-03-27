<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

/**
 * Console Command: php artisan setup
 *
 * Runs all the essential commands to get the webserver up and running!
 *
 * @author Oliver G.
 * @package GET
 * @category BaseRoutes
 * @version 1.0.0
 */
Artisan::command('setup', function() {
	$this->info("//////////////////////////////////////////////");
	$this->info("//                AntelopePHP               //");
	$this->info("//         Advanced Setup Script 2.0        //");
	$this->info("//////////////////////////////////////////////");

	//Skips 2 lines
	$this->line("");
	$this->line("");

	$this->info("🚀 Starting script setup...");

	$this->comment("👷 Turning on maintenance mode...");
	$this->call('down');

	$this->question("💾 Running database migrations...");
	$this->call('migrate');

	$this->question("🗑️ Clearing application cache...");
	$this->call('cache:clear');

	$this->question("🗑️ Clearing and caching config...");
	$this->call('config:cache');

	$this->comment("👷 Turning off maintenance mode...");
	$this->call('up');

	$this->info("🏁 Setup completed!");
});

/**
 * Console Command: php artisan memcache
 *
 * Clears all the cache for the website!
 *
 * @author Oliver G.
 * @package GET
 * @category BaseRoutes
 * @version 1.0.0
 */
Artisan::command('memcache', function() {
	$this->info("🚀 Starting memcache reset...");

	$this->comment("👷 Turning on maintenance mode...");
	$this->call('down');

	$this->question("🗑️ Clearing all cache...");
	$this->call('optimize:clear');

	$this->comment("👷 Turning off maintenance mode...");
	$this->call('up');

	$this->info("🏁 Memcache reset completed!");
});