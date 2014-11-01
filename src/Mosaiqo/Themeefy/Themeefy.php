<?php namespace Mosaiqo\Themeefy;

use Illuminate\View\Factory;

use Mosaiqo\Themeefy\Contracts\ThemeInterface;
use Mosaiqo\Themeefy\Resolver\Resolver;

/**
 * Class Themeefy
 * Presets the theme path for the default view paths.
 * @package Mosaiqo\Themeefy
 */
class Themeefy implements ThemeInterface{
	/**
	 * @var
	 */
	private $theme;

	/**
	 * @var Factory
	 */
	private $view;

	/**
	 * @param ThemeViewFinder $view
	 */
	public function __construct(ThemeViewFinder $view)
	{
		$this->view = $view;
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

		$this->view->addThemeLocation($theme);

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
}