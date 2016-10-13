<?php
namespace App\Entity;

use Doctrine\ORM\Mapping;

/**
 * @Entity
 * @Table(name="tasks")
 */
class TaskEntity {
	/**
	* @var integer
	* @Id
    * @Column(name="id",type="guid")
    * @GeneratedValue(strategy="UUID")
	*/
	protected $id;

    /**
     * @var string
     * @Column(name="title", type="string", length=255)
     */
    protected $title;

	/**
     * @var string
     * @Column(name="description", type="string")
     */
	protected $description;

    /**
     * @var boolean
     * @Column(name="completed", type="boolean")
     */
    protected $completed;

    /**
     * @var datetime
     * @Column(name="created_date", type="datetime");
     */
    protected $createdDate;

    /**
     * Get id
     *
     * @return guid
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return TaskEntity
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return TaskEntity
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set done
     *
     * @param boolean $done
     *
     * @return TaskEntity
     */
    public function setDone($done)
    {
        $this->done = $done;

        return $this;
    }

    /**
     * Get done
     *
     * @return boolean
     */
    public function getDone()
    {
        return $this->done;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return TaskEntity
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set completed
     *
     * @param boolean $completed
     *
     * @return TaskEntity
     */
    public function setCompleted($completed)
    {
        $this->completed = $completed;

        return $this;
    }

    /**
     * Get completed
     *
     * @return boolean
     */
    public function getCompleted()
    {
        return $this->completed;
    }
}
