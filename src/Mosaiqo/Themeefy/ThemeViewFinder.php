<?php namespace Mosaiqo\Themeefy;

use Illuminate\Support\Facades\Config;
use Illuminate\View\FileViewFinder;


/**
 * Class ThemeViewFinder
 *
 * Overrides default Illuminate\View\FileViewFinder to add functionality.
 *
 * @package Mosaiqo\Themeefy
 */
class ThemeViewFinder extends FileViewFinder
{

	/**
	 * Prepends theme location to the view paths to first load the theme views.
	 * @param $themeName
	 */
	public function addThemeLocation($themeName)
	{

		$qualifiedThemePath = $this->getThemePath( $themeName );

		array_splice( $this->paths, 0, 0, $qualifiedThemePath );

	}

	/**
	 * Composes the theme path in order of the configs.
	 *
	 * @param $themeName
	 *
	 * @return string
	 */
	private function getThemePath( $themeName )
	{
		$path = Config::get( 'themeefy::themes_path' );

		return $path . DIRECTORY_SEPARATOR . $themeName . DIRECTORY_SEPARATOR . 'views' ;
	}


}
