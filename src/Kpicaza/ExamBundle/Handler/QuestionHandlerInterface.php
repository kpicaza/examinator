<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kpicaza\ExamBundle\Handler;

interface QuestionHandlerInterface
{

    /**
     * 
     * @param type $id
     */
    public function get($id);
    
    /**
     * 
     * @param array $parameters
     */
    public function getList(array $parameters);
}
