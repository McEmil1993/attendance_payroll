<?php

class route
{	

	public function __construct($url){
		$arr_url = explode('/', rtrim($url, '/'));
		$filename = rtrim($arr_url[0], '/').'Controller.php';
		$class = rtrim($arr_url[0], '/').'Controller';

		if($arr_url[0] == ""){
			$filename = 'homeController.php';
			$class = 'homeController';
		}

		if (file_exists(PATH_CONTROLLER.$filename))
		{
			require PATH_CONTROLLER.$filename;
			$controller = new $class();

			if (isset($arr_url[1]) != ""){
				$function = $arr_url[1];
				$controller->$function();
			}
			else{
				$controller->index();
			}
		} 
		else{
			// require PATH_CONTROLLER.'errorController.php';
			// $controller = new errorController();
			// $controller->index();

			echo "Error!";
		}
	}


}


?>