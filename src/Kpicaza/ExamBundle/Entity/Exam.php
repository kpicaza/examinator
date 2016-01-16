<?php

namespace Kpicaza\ExamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Exam
 * 
 * @ExclusionPolicy("all")
 */
class Exam
{

    /**
     * @var integer
     * @Expose
     */
    private $id;

    /**
     * @var string
     * @Expose
     */
    private $title;

    /**
     * @var string
     * @Expose
     */
    private $description;

    /**
     * @var \DateTime
     * @Expose
     */
    private $created_at;

    /**
     * @var \DateTime
     * @Expose
     */
    private $updated_at;

    /**
     * @var string
     * @Expose
     */
    private $subject;

    /**
     * @var string
     */
    private $access_code;

    /**
     * @var boolean
     * @Expose
     */
    private $is_active = false;

    /**
     * @var boolean
     * @Expose
     */
    private $has_help = true;

    /**
     * @var integer
     * @Expose
     */
    private $to_aprove;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @Expose
     */
    private $questions;

    /**
     * Get id
     *
     * @return integer
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
     * @return Exam
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
     * @return Exam
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Exam
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Exam
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        if (!$this->getCreatedAt()) {
            $this->created_at = new \DateTime();
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updated_at = new \DateTime();
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return Exam
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set accessCode
     *
     * @param string $accessCode
     *
     * @return Exam
     */
    public function setAccessCode($accessCode)
    {
        $this->access_code = $accessCode;

        return $this;
    }

    /**
     * Get accessCode
     *
     * @return string
     */
    public function getAccessCode()
    {
        return $this->access_code;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Exam
     */
    public function setIsActive($isActive)
    {
        $this->is_active = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * Set hasHelp
     *
     * @param boolean $hasHelp
     *
     * @return Exam
     */
    public function setHasHelp($hasHelp)
    {
        $this->has_help = $hasHelp;

        return $this;
    }

    /**
     * Get hasHelp
     *
     * @return boolean
     */
    public function getHasHelp()
    {
        return $this->has_help;
    }

    /**
     * Set toAprove
     *
     * @param integer $toAprove
     *
     * @return Exam
     */
    public function setToAprove($toAprove)
    {
        $this->to_aprove = $toAprove;

        return $this;
    }

    /**
     * Get toAprove
     *
     * @return integer
     */
    public function getToAprove()
    {
        return $this->to_aprove;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->questions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add question
     *
     * @param \Kpicaza\ExamBundle\Entity\Question $question
     *
     * @return Exam
     */
    public function addQuestion(\Kpicaza\ExamBundle\Entity\Question $question)
    {
        $this->questions[] = $question;

        return $this;
    }

    /**
     * Remove question
     *
     * @param \Kpicaza\ExamBundle\Entity\Question $question
     */
    public function removeQuestion(\Kpicaza\ExamBundle\Entity\Question $question)
    {
        $this->questions->removeElement($question);
    }

    /**
     * Get questions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestions()
    {
        return $this->questions;
    }

}
