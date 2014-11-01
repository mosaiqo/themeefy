<?php namespace Mosaiqo\Themeefy;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Factory;
use Mosaiqo\Themeefy\Resolver\Resolver;


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
		$this->package( 'mosaiqo/themeefy', 'themeefy' );
	}
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{

		$this->app->bindShared( 'view.finder', function ( $app ) {
			$paths = $app['config']['view.paths'];

			return new ThemeViewFinder( $app['files'], $paths );
		} );
		$this->app->bindShared( 'Mosaiqo\Themeefy\Contracts\ThemeInterface', function ( $app ) {
			return new Themeefy(new Resolver(), $app['view.finder']);
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
