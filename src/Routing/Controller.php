<?php

namespace Routing;

use App\App;
use Slim\Slim;
use App\Core\Applications;
use App\Core\Config;

abstract class Controller {

    /**
     * @var App
     */
    protected $app;
    protected $requestData;

    public function __construct(){
        $this->app = Slim::getInstance();
        
        if( $this->app->request()->isPost() || $this->app->request()->isPut() ){
            $this->requestData = $this->app->request()->params();
        }
    }
    
    public static function __callStatic($name, $arguments) {
        $calledClass = get_called_class();
        $obj         = new $calledClass;
        $name        = preg_replace('/^___/','',$name);
        call_user_func_array(array($obj, $name), $arguments);
    }
    
    /**
     *  @return App
     */
    protected function getApp(){
        return $this->app;
    }
    
    /**
     * @return string
     */
    protected function getName(){
        return $this->app->router()->getCurrentRoute()->getName();
    }
    
    /**
     * @return array
     */
    protected function getQueryVars( $key = null ){
        if( $key != null ){
            return $this->app->request()->get( $key );
        }

        return $this->app->request()->get();
    }

    /**
     * @return string
     */ 
    protected function getHeader( $header ){
        return $this->app->request->headers->get( $header );
        //$this->app->request()->headers( 'Application-ID' );
    }

    /**
     * @return array
     */
    protected function getRequestData( $value = null ){
        if( !is_null( $value ) ){
            if( array_key_exists($value, $this->requestData ) ){
                return $this->requestData[$value];
            }

            return '';
        }
        return $this->requestData;
    }

    /**
     *  @return Json Object
     */
    protected function getRequestBody( $raw = false ){
        if( $raw == false ){
            return json_decode( $this->app->request()->getBody() );
        }

        return $this->app->request()->getBody();
    }

    /**
     *
     */
    protected function getCurrentService(){
        $appId = 0;
        if( Config::getOption("environment") === "development" ){
            $appId = Config::getOption("appId");
        }

        $applications = new Applications();
        $application = $applications->getServiceConfig( $appId );
        return $application;
    }
    
    public static function getNamespace(){
        $reflectionClass = new \ReflectionClass( $this );
        var_dump( $reflectionClass );
    }
    
    public function getAnnotations(){
        $rc = new \ReflectionClass( get_class( $this ) );   
        $baseAnnotation = $rc->getDocComment(); 
        $methods = $rc->getMethods();
        
        $annotations = array();
        
        foreach( $methods as $method ){
            if( $method->class == get_class( $this ) ){
                $annotation = new Annotation();
                $annotation->class = get_class( $this );
                $annotation->baseAnnotation = $baseAnnotation;                
                $annotation->method = $method->name;
                $annotation->annotation = $rc->getMethod( $annotation->method )->getDocComment();

                array_push( $annotations, $annotation );
            }
        }   
        return $annotations;
    }
    
    public function ValidateRequiredFields( $fields ){
        foreach( $fields as $field ){
			if( !property_exists( $this->getRequestBody(), $field ) ){
                $this->getApp()->sendResponse( array(
				    'message' => 'Missing field in request body: '. $field
                ));
                
                $this->getApp()->setResponseStatus ( 412 );
                return false;
			}
		}
        
        return true;   
    }

    public function ValidateRequiredRequestFields( $fields = array(), $body = null ){
        $body = ( $body == null ) ? $this->getRequestBody() : $body;

        if( $body === null ){
            $this->getApp()->sendResponse( array('error' => 'Missing json body with data' ) );
            $this->getApp()->setResponseStatus( 412 );
            return false;
        }

        foreach( $fields as $field ){
            if( !property_exists( $body , $field ) ){
                $this->getApp()->sendResponse( array('error' => 'Missing field in body request: ' . $field ) );
                $this->getApp()->setResponseStatus( 412 );

                return false;
            }
        }

        return true;
    }

    public function allowedGetFields( $fields = array(), $body = null ){
        $parameters = ( $body == null ) ? $this->getQueryVars() : $body;

        foreach( $parameters as $key => $parameter ){
            $hasFound = false;

            foreach( $fields as $field ){
                if( $key == $field ){
                    $hasFound = true;
                }
            }

            if( $hasFound == false ){
                return false;
            }
        }

        return true;
    }
}