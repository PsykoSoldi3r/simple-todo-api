<?php
namespace App;

class Config {

	public static function getDatabaseConfig(){
		$environment = getenv( 'APPLICATION_ENV' );

		switch( $environment ){
			case 'development':
				return array(
					"host"=>"127.0.0.1",
					"driver"=>"pdo_mysql",
					"user"=>"root",
					"password"=>"root",
					"dbname"=>"todo_api",
					"baseurl" => "",
                    "uploadurl" => "http://simple.todo.api/",
					"JWT_KEY" => "hul4n_p1d63y_jw7_53cr37_k3y",
					"rootUrl" => "",
					"timezone" => "Europe/Amsterdam"
				);
			break;

			case 'production':
				return array(
					"host"=>"127.0.0.1",
					"driver"=>"pdo_mysql",
					"user"=>"root",
					"password"=>"root",
					"dbname"=>"todo_api",
					"baseurl" => "",
                    "uploadurl" => "http://api-pidgey.hulan.cloud/",
					"JWT_KEY" => "hul4n_p1d63y_jw7_53cr37_k3y",
					"rootUrl" => "",
					"timezone" => "Europe/Amsterdam"
				);
			break;

			default:
				return array(
					"host"=>"127.0.0.1",
					"driver"=>"pdo_mysql",
					"user"=>"root",
					"password"=>"root",
					"dbname"=>"todo_api",
					"baseurl" => "",
                    "uploadurl" => "http://api-pidgey.hulan.cloud/",
					"JWT_KEY" => "hul4n_p1d63y_jw7_53cr37_k3y",
					"rootUrl" => "",
					"timezone" => "Europe/Amsterdam"
				);
			break;
		}
	}

	public static function getConfig (){
		return Config::getDatabaseConfig();
	}
}