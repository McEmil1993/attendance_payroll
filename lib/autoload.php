<?php
	spl_autoload_register('lib');
	spl_autoload_register('controllers');
	spl_autoload_register('models');

	function lib($filename) {
		$path = 'lib/';
		$file = $path . $filename . '.php';

		if (file_exists($file)) {
			include $file;
		}
	}

	function controllers($class) {
		$path = 'controllers/';
		$file = $path . $class . '.php';
		if (file_exists($file)) {
			include $file;
		}
	}

	function models($class) {
		$path = 'models/';
		$file = $path . $class . '.php';
		
		if (file_exists($file)) {
			include $file;
		}
	}
?>