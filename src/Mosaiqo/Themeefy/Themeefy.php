<?php namespace Mosaiqo\Themeefy;


use Mosaiqo\Themeefy\Contracts\ThemeInterface;
use Mosaiqo\Themeefy\Finder\ViewFinder;


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
	 * @var ViewFinder
	 */
	private $view;

	/**
	 * @param ViewFinder $view
	 */
	public function __construct(ViewFinder $view)
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