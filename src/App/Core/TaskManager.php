<?php

namespace App\Core;

use App\Config;
use App\Entity\TaskEntity;
use Doctrine\ORM\EntityManager;

class TaskManager {

    /** @var EntityManager */
	private $em;

    /**
     * TaskManager constructor.
     * @param EntityManager $em
     */
	public function __construct( EntityManager $em ){
		$this->em = $em;
	}

    /**
     * @param $title
     * @param string $description
     * @return TaskEntity
     */
	public function CreateTask( $title, $description = "" ){
	    $task = new TaskEntity();

        $task->setTitle( $title );
        $task->setDescription( $description );
        $task->setCreatedDate( new \DateTime() );
        $task->setCompleted( false );

        $this->em->persist( $task );
        $this->em->flush();

		return $task;
	}

    /**
     * @param $id
     * @return TaskEntity|null
     */
	public function GetTask( $id ){
	    return $this->em->find('App\Entity\TaskEntity', $id );
    }

    /**
     * @return TaskEntity[]
     */
	public function GetAllTasks(){
	    return $this->em->getRepository('App\Entity\TaskEntity')->findBy(array(),array(
	        'createdDate' => 'desc'
        ));
    }

    /**
     * @param TaskEntity $task
     */
    public function DeleteTask( TaskEntity $task ){
        $this->em->remove( $task );
        $this->em->flush();
    }

    /**
     * @param TaskEntity $task
     * @param bool $isCompleted
     */
    public function ChangeCompleteState( TaskEntity $task, $isCompleted ){
        $task->setCompleted( $isCompleted );
        return $task;
    }

	public static function ConvertToArray( TaskEntity $task ){
		return array(
			'id' => $task->getId(),
            'title' => $task->getTitle(),
            'description' => $task->getDescription(),
            'completed' => $task->getCompleted()
		);
	}
}