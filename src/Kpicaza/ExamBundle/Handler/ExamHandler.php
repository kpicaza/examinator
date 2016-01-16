<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kpicaza\ExamBundle\Handler;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Kpicaza\ExamBundle\Exception\Rest\InvalidFormException;
use Kpicaza\ExamBundle\Form\Type\PagerFormType;
use Kpicaza\ExamBundle\Form\Model\PagerFormModel;

/**
 * 
 */
class ExamHandler implements ExamHandlerInterface
{

    /**
     *
     * @var type 
     */
    private $om;

    /**
     *
     * @var type 
     */
    private $entityClass;

    /**
     *
     * @var type 
     */
    private $repository;
    
    /**
     *
     * @var type 
     */
    private $formFactory;


    /**
     * 
     * @param \AppBundle\Handler\ObjectManager $om
     * @param type $entityClass
     */
    public function __construct(EntityManager $om, $entityClass, FormFactoryInterface $formFactory)
    {
        $this->om = $om;
        $this->entityClass = $entityClass;
        $this->repository = $this->om->getRepository($this->entityClass);
        $this->formFactory = $formFactory;
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    public function get($id)
    {
        return $this->repository->find($id);
    }

    /**
     * 
     * @param \DateTime $since
     * @param type $limit
     * @param type $offset
     * @return type
     */
    public function getList(array $parameters)
    {

        $form = $this->formFactory->create(new PagerFormType(), new PagerFormModel());
        $form->submit($parameters);
        if ($form->isValid()) {
            $data = $form->getData();
            return $this->repository->findForRest($data->getSince(), $data->getLimit(), $data->getOffset(), $data->getKeywords());
        }
        
        $exc = new InvalidFormException('Invalid submitted data', $form);
        return $form->getErrors();

    }

}
