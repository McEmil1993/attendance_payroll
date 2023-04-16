<?php

class view{

	public function render($url, $data = array()){
		require PATH_VIEW.$url;
	}

	public function route($url){
		header('location: /'.$url);
	}

	public function onBack(){
		header("Location: " . $_SERVER["HTTP_REFERER"]);
	}
	
}

?>