<?php

namespace Kpicaza\ExamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExamResult
 */
class ExamResult
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $total_points;

    /**
     * @var \DateTime
     */
    private $start_datetime;

    /**
     * @var \DateTime
     */
    private $end_datetime;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;

    /**
     * @var \Kpicaza\ExamBundle\Entity\Exam
     */
    private $exam;

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
     * Set totalPoints
     *
     * @param integer $totalPoints
     *
     * @return ExamResult
     */
    public function setTotalPoints($totalPoints)
    {
        $this->total_points = $totalPoints;

        return $this;
    }

    /**
     * Get totalPoints
     *
     * @return integer
     */
    public function getTotalPoints()
    {
        return $this->total_points;
    }

    /**
     * Set startDatetime
     *
     * @param \DateTime $startDatetime
     *
     * @return ExamResult
     */
    public function setStartDatetime($startDatetime)
    {
        $this->start_datetime = $startDatetime;

        return $this;
    }

    /**
     * Get startDatetime
     *
     * @return \DateTime
     */
    public function getStartDatetime()
    {
        return $this->start_datetime;
    }

    /**
     * Set endDatetime
     *
     * @param \DateTime $endDatetime
     *
     * @return ExamResult
     */
    public function setEndDatetime($endDatetime)
    {
        $this->end_datetime = $endDatetime;

        return $this;
    }

    /**
     * Get endDatetime
     *
     * @return \DateTime
     */
    public function getEndDatetime()
    {
        return $this->end_datetime;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return ExamResult
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
     * @return ExamResult
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
     * Set exam
     *
     * @param \Kpicaza\ExamBundle\Entity\Exam $exam
     *
     * @return ExamResult
     */
    public function setExam(\Kpicaza\ExamBundle\Entity\Exam $exam = null)
    {
        $this->exam = $exam;

        return $this;
    }

    /**
     * Get exam
     *
     * @return \Kpicaza\ExamBundle\Entity\Exam
     */
    public function getExam()
    {
        return $this->exam;
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

}
