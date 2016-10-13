<?php
	require_once dirname(__FILE__).'/../vendor/autoload.php';

	use App\App;

	$app = new App();
	$routingManager = $app->getRoutingManager();

	foreach( $argv as $arg ){
		if( $arg === '--cache-clean' ){
			$routingManager->clearCache( true );
		}
	}
?>