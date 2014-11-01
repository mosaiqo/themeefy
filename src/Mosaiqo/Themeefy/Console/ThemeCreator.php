<?php namespace Mosaiqo\Themeefy\Console;


use Illuminate\Console\Command;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Contracts\Foundation\Application;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class ThemeCreator
 *
 * @package Mosaiqo\Themeefy\Console
 */
class ThemeCreator extends Command {

	/**
	 * @var array
	 */
	protected $fileStructure = [];

	/**
	 * @var array
	 */
	protected $stubFiles = [];

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'themeefy:create';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Creates a theme boilerplate.';

	/**
	 * @var
	 */
	protected $themeName;
	/**
	 * @var
	 */
	protected $styleFrameworks;
	/**
	 * @var
	 */
	protected $scriptFrameworks;
	/**
	 * @var Filesystem
	 */
	private $filesystem;
	/**
	 * @var Application
	 */
	private $app;
	/**
	 * @var ThemeStubGenerator
	 */
	private $generator;

	/**
	 * Create a new command instance.
	 *
	 * @param Filesystem         $filesystem
	 *
	 * @param ThemeStubGenerator $generator
	 *
	 * @return ThemeCreator
	 */
	public function __construct(Filesystem $filesystem, ThemeStubGenerator $generator)
	{
		parent::__construct();
		$this->filesystem = $filesystem;
		$this->generator = $generator;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->themeName = $this->argument( 'name' );

		$this->loadStyleFrameworks();

		$this->loadScriptFrameworks();


		$this->loadInput();

		$this->fileStructure = $this->laravel['config']['themeefy::structure'];
		$paths = str_replace(base_path(), "", $this->laravel['config']['themeefy::theme.path']);

		$this->createDirectoryStructure( $paths . DIRECTORY_SEPARATOR . $this->themeName );
	}


	/**
	 * @param $string
	 *
	 * @return array
	 */
	private function parse($string)
	{
		$array = preg_split( '/ ?, ?/', $string, null, PREG_SPLIT_NO_EMPTY );

		return compact( 'properties' );
	}


	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments() {
		return [
			[
				'name',
				InputArgument::REQUIRED,
				'The name for your awesome theme.'
			],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions() {
		return [
			[
				'css',
				null,
				InputOption::VALUE_OPTIONAL,
				'A comma-separated list of css frameworks/libraries for this theme.',
				"bootstrap"
			],
			[
				'js',
				null,
				InputOption::VALUE_OPTIONAL,
				'A comma-separated list of JS frameworks/libraries for this theme.',
				"jquery, bootstrap"
			],
			[
				'taskManager',
				null,
				InputOption::VALUE_OPTIONAL,
				"Which task manager you´ll like to use? \nPossible values [grunt || gulp]",
				"gulp"
			],
			[
				'vendor',
				null,
				InputOption::VALUE_OPTIONAL,
				"The vendor name",
				""
			],
		];
	}

	/**
	 * @param $mainPath
	 */
	protected function createDirectoryStructure( $mainPath )
	{
		$this->filesystem->makeDirectory($mainPath);
		$this->createDirectory($this->fileStructure , $mainPath);
	}


	/**
	 * @param $structure
	 * @param $mainPath
	 */
	private function createDirectory( $structure, $mainPath )
	{
		foreach ( $structure as $folder => $file )
		{
			if(is_array($file))
			{
				$directory = $mainPath . DIRECTORY_SEPARATOR . $folder;
				$this->filesystem->makeDirectory($directory);
				$this->createDirectory( $file, $directory );
			}
			elseif(is_string($file))
			{

				if ($this->templateExists($file, $mainPath))
					$this->generator->make($this->input, $this->loadTemplate($file, $mainPath), $this->getDestination($mainPath, $file));
				else

					$this->filesystem->put($mainPath . DIRECTORY_SEPARATOR . $file, "");

			}
		}
	}


	/**
	 * @param $mainPath
	 * @param $file
	 *
	 * @return string
	 */
	public function getDestination( $mainPath, $file )
	{
		return base_path() . $mainPath . DIRECTORY_SEPARATOR . $file;
	}

	/**
	 * @param $file
	 *
	 * @param $mainPath
	 *
	 * @return string
	 */
	private function loadTemplate($file, $mainPath)
	{
		$path = $this->clearBasePath( $mainPath );
		return $this->stubPath( $file, $path );
	}

	/**
	 * @param $file
	 * @param $mainPath
	 *
	 * @return bool
	 */
	private function templateExists($file, $mainPath)
	{
		$path = $this->clearBasePath( $mainPath );
		return file_exists($this->stubPath( $file, $path ));
	}

	/**
	 * @param $mainPath
	 *
	 * @return mixed
	 */
	private function clearBasePath( $mainPath )
	{
		return str_replace( "/resources/themes/{$this->themeName}", '', $mainPath );
	}

	/**
	 * @param $file
	 * @param $path
	 *
	 * @return string
	 */
	private function stubPath( $file, $path )
	{
		return __DIR__ . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $file;
	}

	/**
	 *
	 */
	private function loadInput() {
		$this->input = [
			"vendor" => $this->option( 'vendor' )
		];
	}

	/**
	 *
	 */
	private function loadStyleFrameworks()
	{
		$this->styleFrameworks = $this->parse($this->option('css'));
	}

	/**
	 *
	 */
	private function loadScriptFrameworks()
	{
		$this->scriptFrameworks = $this->parse($this->option('js'));
	}
}
