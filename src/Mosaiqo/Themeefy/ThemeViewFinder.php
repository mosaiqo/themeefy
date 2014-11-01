<?php namespace Mosaiqo\Themeefy;

use Illuminate\Support\Facades\Config;
use Illuminate\View\FileViewFinder;
use Illuminate\Filesystem\Filesystem;



class ThemeViewFinder extends FileViewFinder
{

	public function addThemeLocation($themeName)
	{

		$qualifiedThemePath = $this->getThemePath( $themeName );

		array_splice( $this->paths, 0, 0, $qualifiedThemePath );

	}

	private function getThemePath( $themeName )
	{
		$path = Config::get( 'themeefy::themes_path' );

		return $path . DIRECTORY_SEPARATOR . $themeName . DIRECTORY_SEPARATOR . 'views' ;
	}


}
