<?php

namespace App\Controllers;

use App\Core\TaskManager;
use Routing\Controller;
use App\Core\ErrorResponse;
use App\Core\UserManager;

class TaskController extends Controller {

    /**
     * @Route('/tasks/:id')
     * @Method('GET')
     * @Name('get.task')
     */
    public function GetTask( $id ){
        $tm = new TaskManager( $this->getApp()->getEntityManager() );

        $task = $tm->GetTask( $id );

        if( $task == null ){
            $this->getApp()->setResponseStatus( 404 );
            return;
        }

        $this->getApp()->sendResponse( TaskManager::ConvertToArray( $task ) );
    }

	/** 
	 * @Route('/tasks')
	 * @Method('GET')
	 * @Name('get.all.tasks')
	 */
	public function GetAllTasks(){
        $tm = new TaskManager( $this->getApp()->getEntityManager() );

        $tasks = $tm->GetAllTasks();

        $response = array();
        foreach( $tasks as $task ){
            array_push( $response, TaskManager::ConvertToArray( $task ) );
        }

        $this->getApp()->sendResponse( $response );
	}

    /**
     * @Route('/tasks')
     * @Method('POST')
     * @Name('create.task')
     */
	public function CreateTask(){
	    if( $this->ValidateRequiredRequestFields( ['title'] ) ) {
            $tm = new TaskManager($this->getApp()->getEntityManager());

            $body = $this->getRequestBody();

            $title = $body->title;
            $description = ( property_exists( $body , "description" ) ) ? $body->description : "";

            $task = $tm->CreateTask( $title, $description );
            $this->getApp()->sendResponse( TaskManager::ConvertToArray( $task ) );
        }
    }

    /**
     * @Route('/tasks/:id')
     * @Method('PUT')
     * @Name('update.tasks')
     */
    public function UpdateTask( $id ){
        $tm = new TaskManager( $this->getApp()->getEntityManager() );

        $body = $this->getRequestBody();
        $task = $tm->GetTask( $id );

        if( property_exists( $body, "completed" ) ){
            $task = $tm->ChangeCompleteState( $task, $body->completed );
        }

        $this->getApp()->getEntityManager()->persist( $task );
        $this->getApp()->getEntityManager()->flush();

        $this->getApp()->sendResponse( TaskManager::ConvertToArray( $task ) );
    }

    /**
     * @Route('/tasks/:id')
     * @Method('DELETE')
     * @Name('.delete.task')
     */
    public function DeleteTask( $id ){
        $tm = new TaskManager( $this->getApp()->getEntityManager() );

        $task = $tm->GetTask( $id );

        if ( $task == null ){
            $this->getApp()->setResponseStatus(404);
            return;
        }

        $tm->DeleteTask( $task );
    }
}