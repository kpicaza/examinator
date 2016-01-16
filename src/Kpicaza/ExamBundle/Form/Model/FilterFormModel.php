<?php

namespace Kpicaza\ExamBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class FilterFormModel extends PagerFormModel
{

    /**
     * @Assert\Regex("/^[a-z\-0-9]/")
     *
     * @var type 
     */
    private $exam_id;

    public function getExamId()
    {
        return $this->exam_id;
    }

    public function setExamId($exam_id)
    {
        $this->exam_id = $exam_id;
    }

}
