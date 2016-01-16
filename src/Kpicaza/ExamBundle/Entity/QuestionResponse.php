<?php

namespace Kpicaza\ExamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * QuestionResponse
 */
class QuestionResponse
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Kpicaza\ExamBundle\Entity\Answer
     */
    private $answer;

    /**
     * @var \Kpicaza\ExamBundle\Entity\Question
     */
    private $question;


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
     * Set answer
     *
     * @param \Kpicaza\ExamBundle\Entity\Answer $answer
     *
     * @return QuestionResponse
     */
    public function setAnswer(\Kpicaza\ExamBundle\Entity\Answer $answer = null)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return \Kpicaza\ExamBundle\Entity\Answer
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set question
     *
     * @param \Kpicaza\ExamBundle\Entity\Question $question
     *
     * @return QuestionResponse
     */
    public function setQuestion(\Kpicaza\ExamBundle\Entity\Question $question = null)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return \Kpicaza\ExamBundle\Entity\Question
     */
    public function getQuestion()
    {
        return $this->question;
    }
}
