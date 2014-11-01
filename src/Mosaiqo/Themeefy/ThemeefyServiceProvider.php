<?php namespace Mosaiqo\Themeefy;

use Illuminate\Support\ServiceProvider;
use Mosaiqo\Themeefy\Finder\ViewFinder;


/**
 * Class ThemeefyServiceProvider
 *
 * @package Mosaiqo\Themeefy
 */
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

		$this->registerViewFinder();

		$this->registerThemeefy();

		$this->registerArtisanCommand();

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

	/**
	 * Registers Package view finder to override Laravel's one.
	 */
	public function registerViewFinder() {
		$this->app->bindShared( 'view.finder', function ( $app ) {
			$paths = $app['config']['view.paths'];

			return new ViewFinder( $app['files'], $paths );
		} );
	}

	/**
	 * Registers Themeefy
	 */
	public function registerThemeefy() {
		$this->app->bindShared( 'Mosaiqo\Themeefy\Contracts\ThemeInterface', function ( $app ) {
			$paths = $app['config']['themeefy::theme.path'];

			return new Themeefy( $app['view.finder'], $paths );
		} );
	}

	/**
	 * Register the Artisan command
	 *
	 * @return void
	 */
	public function registerArtisanCommand() {
		$this->app->bindShared( 'themeefy.theme.creator', function ( $app ) {
			return $app->make( 'Mosaiqo\Themeefy\Console\ThemeCreator' );
		} );

		$this->commands( 'themeefy.theme.creator' );
	}


}
