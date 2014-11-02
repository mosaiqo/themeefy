<?php namespace Mosaiqo\Themeefy\Contracts;


/**
 * Class ThemeViewFinder
 *
 * Overrides default Illuminate\View\FileViewFinder to add functionality.
 *
 * @package Mosaiqo\Themeefy
 */
interface ThemeViewFinderInterface {
	/**
	 * Prepends theme location to the view paths to first load the theme views.
	 *
	 * @param $themePath
	 *
	 */
	public function addThemeLocation( $themePath );
}