<?php
	require_once dirname(__FILE__).'/vendor/autoload.php';

	if( $_SERVER['REQUEST_METHOD'] == 'OPTIONS' ){
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, Bearer,  X-HTTP-Method-Override');
	}else{
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, Bearer,  X-HTTP-Method-Override');
		
		$app = new App\App();
		$app->run();
	}
?>
