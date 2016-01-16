<?php

namespace Kpicaza\ExamBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * ExamResultFormModel
 */
class ExamResultFormModel
{

    /**
     * @Assert\NotBlank()
     * @Assert\Regex("/^[a-z\-0-9]/")
     *
     * @var type 
     */
    private $exam_id;

    /**
     * @Assert\DateTime()
     *
     * @var type 
     */
    private $start_datetime;

    /**
     * @Assert\DateTime()
     *
     * @var type 
     */
    private $end_datetime;
    
    /**
     * 
     * @return type
     */
    private $format = 'json';

    public function getExamId()
    {
        return $this->exam_id;
    }

    /**
     * 
     * @param type $exam_id
     */
    public function setExamId($exam_id)
    {
        $this->exam_id = $exam_id;
    }

    /**
     * 
     * @return type
     */
    public function getStartDatetime()
    {
        return $this->start_datetime;
    }

    /**
     * 
     * @param type $start_datetime
     */
    public function setStartDatetime($start_datetime)
    {
        if (true === $this->validateDate($start_datetime)) {
            $this->start_datetime = $start_datetime;
        }
    }

    /**
     * 
     * @return type
     */
    public function getEndDatetime()
    {
        return $this->end_datetime;
    }

    /**
     * 
     * @param type $end_datetime
     */
    public function setEndDatetime($end_datetime)
    {
        if (true === $this->validateDate($end_datetime)) {
            $this->end_datetime = $end_datetime;
        }
    }
    /**
     * 
     * @return type
     */
    public function getFormat()
    {
        return $this->format;
    }
    /**
     * 
     * @return type
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * 
     * @param type $date
     * @param type $format
     * @return type
     */
    private function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $time = strtotime($date);
        $d = new \DateTime(date($format, $time));
        return $d && $time != 0 && strtotime($d->format($format)) == $time;
    }

}
