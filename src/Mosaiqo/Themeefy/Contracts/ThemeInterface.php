<?php namespace Mosaiqo\Themeefy\Contracts;

/**
 * Interface ThemeInterface
 *
 * @package Mosaiqo\Themeefy\Contracts
 */
interface ThemeInterface
{
	/**
	 * Sets the correct theme
	 *
	 * @param $theme
	 *
	 * @return void
	 */
	public function set( $theme );

	/**
	 * Gets the set theme
	 *
	 * @return mixed
	 */
	public function get();
}