<?php namespace Mosaiqo\Themeefy;


use Mosaiqo\Themeefy\Contracts\ThemeInterface;
use Mosaiqo\Themeefy\Contracts\ThemeViewFinderInterface;
use Mosaiqo\Themeefy\Finder\ViewFinder;


/**
 * Class Themeefy
 * Presets the theme path for the default view paths.
 * @package Mosaiqo\Themeefy
 */
class Themeefy implements ThemeInterface{

	/**
	 * THe used theme
	 * @var
	 */
	private $theme;


	/**
	 * ThemeViewFinderInterface instance
	 *
	 * @var ThemeViewFinderInterface
	 */
	private $viewFinder;

	/**
	 * The path to the themes folder
	 * @var array
	 */
	private $themes_path;


	/**
	 * @param ThemeViewFinderInterface $viewFinder
	 * @param string      $themes_path
	 */
	public function __construct(ThemeViewFinderInterface $viewFinder, $themes_path = '')
	{
		$this->viewFinder = $viewFinder;
		$this->themes_path = $themes_path;
	}

	/**
	 * Sets the correct theme
	 *
	 * @param $theme
	 *
	 * @return void
	 */
	public function set( $theme )
	{
		$this->theme = $theme;

		$this->viewFinder->addThemeLocation( $this->compoundThemePath($theme) );

	}

	/**
	 * Gets the set theme
	 *
	 * @return mixed
	 */
	public function get()
	{
		return $this->theme;
	}


	/**
	 * Composes the theme path in order of the configs.
	 *
	 * @param $themeName
	 *
	 * @return string
	 */
	private function compoundThemePath( $themeName )
	{
		return $this->themes_path . DIRECTORY_SEPARATOR . $themeName . DIRECTORY_SEPARATOR . 'views';
	}
}