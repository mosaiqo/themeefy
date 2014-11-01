<?php namespace Mosaiqo\Themeefy\Finder;

use Illuminate\Support\Facades\Config;
use Illuminate\View\FileViewFinder;


/**
 * Class ThemeViewFinder
 *
 * Overrides default Illuminate\View\FileViewFinder to add functionality.
 *
 * @package Mosaiqo\Themeefy
 */
class ViewFinder extends FileViewFinder
{

	/**
	 * Prepends theme location to the view paths to first load the theme views.
	 *
	 * @param $themePath
	 *
	 */
	public function addThemeLocation($themePath)
	{
		array_splice( $this->paths, 0, 0, $themePath );
	}



}
