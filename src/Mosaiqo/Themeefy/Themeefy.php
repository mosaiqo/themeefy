<?php namespace Mosaiqo\Themeefy;


use Illuminate\Contracts\Foundation\Application;

use Illuminate\Contracts\View\View;
use Illuminate\View\Factory;
use Mosaiqo\Themeefy\Resolver\Resolver;

class Themeefy
{
	private $theme;
	private $resolver;
	/**
	 * @var Factory
	 */
	private $view;

	/**
	 * @param Resolver $resolver
	 * @param Factory  $view
	 */
	public function __construct(Resolver $resolver, ThemeViewFinder $view)
	{
		$this->resolver = $resolver;
		$this->view = $view;
	}

	public function set( $theme )
	{
		$this->theme = $theme;

		$this->view->addThemeLocation($theme);

//		$this->view->addLocation( );

	}

	public function get()
	{
		return $this->theme ?: $this->resolver->resolve();
	}
}