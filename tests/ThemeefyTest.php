<?php

use Mosaiqo\Themeefy\Themeefy;
use Mosaiqo\Themeefy\ThemeViewFinder;

class ThemeefyTest extends Orchestra\Testbench\TestCase
{
	protected $theme;

	public function setUp()
	{
		parent::setUp();

	}

	/**
	 * @test
	 */
	public function themeIsSetCorrectly()
	{
		$finder = $this->mockViewFinder();
		$finder->shouldReceive('addThemeLocation')->once();

		$this->theme = new Themeefy( $finder );
		$this->theme->set('foo');

		$this->assertEquals($this->theme->get(), "foo");
	}


	/**
	 * Mocks View Finder
	 */
	protected function mockViewFinder()
	{
		return Mockery::mock( 'Mosaiqo\Themeefy\Finder\ViewFinder' );
	}


}
