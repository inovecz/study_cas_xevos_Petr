<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap services.
	 *
	 * @return void
	 */
	public function boot() {
		//
	}

	/**
	 * Register services.
	 *
	 * @return void
	 */
	public function register() {
		$file = app_path('Helpers/helper.php');
		if (file_exists($file)) {
			require_once $file;
		}

		// foreach (glob(app_path() . '/Helpers/*.php') as $file) {
	        // require_once($file);
	    // }
	}
}
