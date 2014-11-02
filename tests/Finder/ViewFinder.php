<?php

use Mosaiqo\Themeefy\Finder\ViewFinder;
use Mosaiqo\Themeefy\Themeefy;
use Mosaiqo\Themeefy\ThemeViewFinder;

class ViewFinderTest extends Orchestra\Testbench\TestCase {

	protected $viewFinder;

	public function setUp()
	{
		parent::setUp();
	}

	/**
	 * @test
	 */
	public function itAddsThemeLocation()
	{
		$this->viewFinder = new ViewFinder($this->mockFileSystem(), []);

		$this->viewFinder->addThemeLocation('theme');

		$paths = $this->viewFinder->getPaths();

		$this->assertEquals('theme', $paths[0]);
	}

	/**
	 * @test
	 */
	public function itAlwaysAddsThemeLocationOnFirstPlace()
	{
		$this->viewFinder = new ViewFinder( $this->mockFileSystem(), ['default/path', 'another/path'] );

		$this->viewFinder->addThemeLocation( 'theme' );

		$paths = $this->viewFinder->getPaths();

		$this->assertEquals( 'theme', $paths[0] );
	}

	/**
	 * Mocks View Finder
	 */
	protected function mockFileSystem() {
		return Mockery::mock( 'Illuminate\Filesystem\Filesystem' );
	}

}
