<?php

use Mosaiqo\Themeefy\Themeefy;

class ThemeefyTest extends Orchestra\Testbench\TestCase
{
	protected $theme;

	public function setUp()
	{
		parent::setUp();

		$this->theme = $this->app->make('Mosaiqo\Themeefy\Themeefy');
	}

	/**
	 * @test
	 */
	public function themeIsSetCorrectly()
	{
		$this->theme->set('foo');

		$this->assertEquals($this->theme->get(), "foo");
	}

	/**
	 * @test
	 */
	public function themeShouldBeResolvedAutomaticly()
	{
		$resolver = $this->mockResolver();
		$resolver->shouldReceive('resolve')->once()->andReturn('bar');

		$theme = new Themeefy($resolver);
		$this->assertEquals($theme->get(), 'bar');
	}

	/**
	 *
	 */
	public function filterDetectsThemeInController()
	{
		$controller = $this->mockController('MockedController', 'footheme');

		// Bind route to mocked controller with existing $theme property
		// and call the route bound to it
		$this->app['router']->get( 'foo', 'MockedController@foo' );
		$this->call( 'GET', 'foo' );

		// Check that the final theme is the one set in the filter
		// As set() should have priority over the controller property
		$this->assertEquals( $this->theme->get(), 'someTheme' );

	}


	/**
	 *
	 */
	protected function mockResolver()
	{
		return Mockery::mock( 'Mosaiqo\Themeefy\Resolver\Resolver' );
	}


	/**
	 * @param $name
	 * @param $theme
	 *
	 * @return \Mockery\MockInterface
	 */
	protected function mockController( $name, $theme)
	{
		$controller = Mockery::mock($name);
		$controller->shouldReceive( 'getAfterFilters' )
		           ->once()
		           ->andReturn( [ ] );

		$controller->shouldReceive( 'getBeforeFilters' )
		           ->once()
		           ->andReturn( [ ] );

		$controller->shouldReceive( 'callAction' )
		           ->once()
		           ->withAnyArgs();

		$controller->theme = $theme;

		// Bind controller class to the mocked controller
		$this->app->bind( $name, function ( $app ) use ( $controller ) {
			return $controller;
		} );

		return $controller;
	}

}
