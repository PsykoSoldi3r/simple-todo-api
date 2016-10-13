<?php
namespace App;

use Slim\Slim;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Routing\RoutingManager;
use App\Entity\ApplicationEntity;

class App extends Slim{

	private $routingManager;
	private $isPublicRoute = false;

    /**
     * App constructor.
     */
	public function __construct(){
		parent::__construct();

		$this->routingManager = new RoutingManager( 
			array(
				'cache' => 'cache',
				'controllers_directory' => 'src/App/Controllers',
				'controllers_namespace' => 'App\\Controllers',
				'baseUrl' => Config::getDatabaseConfig()['baseurl']
			)
		);	

		$this->add( $this->routingManager );
	}

    /**
     * @return RoutingManager
     */
	public function getRoutingManager(){
		return $this->routingManager;
	}

    /**
     * @return EntityManager
     */
	public function getEntityManager(){
		if( $this->entityManager === null ){
			$this->entityManager = $this->createEntityManager();
			$this->entityManager->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
		}
		return $this->entityManager;
	}

    /**
     * @return EntityManager
     */
	private function createEntityManager(){
		$paths = array( dirname(__FILE__).'/Entity' );
		$devMode = true;
		$config = Setup::createAnnotationMetadataConfiguration( $paths, $devMode );
		$connectionOptions = Config::getDatabaseConfig();
		return EntityManager::create( $connectionOptions, $config );
	}

    /**
     * @param int $httpCode
     */
	public function setResponseStatus( $httpCode = 200 ){
        $this->response()->status( $httpCode );
	}

    /**
     * @param $array_object
     */
	public function sendResponse( $array_object ){
		$this->response()->header('Content-Type', 'application/json');
        $this->response()->body( json_encode( $array_object ) );
	}

    /**
     * @return bool
     */
	public function getIsPublicRoute(){
		return $this->isPublicRoute;
	}

    /**
     * @param $value
     */
	public function setIsPublicRoute( $value ){
		$this->isPublicRoute = $value;
	}

    /**
     * @param $error
     */
	public function sendError( $error ){
		$this->sendResponse( array(
			'message' => $error->getMessage(),
			'code' => $error->getCode()
		));

		$this->setResponseStatus( $error->getHttp() );
	}
}