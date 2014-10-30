<?php namespace Mosaiqo\Themeefy;

use Illuminate\Support\ServiceProvider;


class ThemeefyServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package( 'mosaiqo/themeefy' );
	}
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bindShared( 'themeefy', function ( $app ) {
			return new Themeefy();
		} );
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [];
	}



}
