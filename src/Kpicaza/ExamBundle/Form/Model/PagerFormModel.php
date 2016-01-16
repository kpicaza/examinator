<?php

namespace Kpicaza\ExamBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class PagerFormModel
{

    /**
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min = 1,
     *      max = 50,
     *      minMessage = "You must set limit to {{ limit }} or more items per call",
     *      maxMessage = "You cannot set limit longer than {{ limit }} items per call"
     * )
     */
    private $limit;

    /**
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min = 0,
     *      max = 10000,
     *      minMessage = "You must set $offset betwen {{ limit }} and 10000",
     *      maxMessage = "You must set $offset betwen 0 and {{ limit }}"
     * )
     */
    private $offset;

    /**
     *
     * @Assert\Regex("/^[a-z\-0-9]/")
     * @var string
     */
    private $keywords;

    /**
     *
     * @var \DateTime
     * 
     * @Assert\DateTime()
     */
    private $since;

    /**
     * 
     * @param type $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    /**
     * 
     * @return type
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * 
     * @param type $offset
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;
    }

    /**
     * 
     * @return type
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * 
     * @param type $keywords
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     * 
     * @return type
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * 
     * @param type $since
     */
    public function setSince($since)
    {
        if (true === $this->validateDate($since)) {
            $this->since = new \DateTime($since);
        }
    }

    /**
     * 
     * @return type
     */
    public function getSince()
    {
        return $this->since;
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
