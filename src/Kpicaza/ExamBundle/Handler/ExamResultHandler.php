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
use Kpicaza\ExamBundle\Form\Type\ExamResultType;
use Kpicaza\ExamBundle\Form\Model\ExamResultFormModel;
use Symfony\Component\Form\Form;

/**
 * 
 */
class ExamResultHandler implements ExamResultHandlerInterface
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

    /**
     * Create a new Page.
     *
     * @param array $parameters
     *
     * @return PageInterface
     */
    public function post(array $parameters)
    {
        $examResultModel = new ExamResultFormModel();

        // Process form does all the magic, validate and hydrate the Page Object.
        return $this->processForm($examResultModel, $parameters, 'POST');
    }

    /**
     * Processes the form.
     *
     * @param ExamResultFormModel  $examResultModel
     * @param array         $parameters
     * @param String        $method
     *
     * @return ContactModel
     *
     * @throws InvalidFormException
     */
    private function processForm(ExamResultFormModel $examResultModel, array $parameters, $method = "PUT")
    {
        $form = $this->formFactory->create(new ExamResultType(), $examResultModel, array('method' => $method));
        $form->submit($parameters, 'PATCH' !== $method);
        if ($form->isValid()) {
            $data = $form->getData();

            // @Todo move to examresult manager
            $exam = $this->om->getRepository('KpicazaExamBundle:Exam')->find($data->getExamId());

            if (null === $exam) {
                throw new \Doctrine\ORM\EntityNotFoundException('Exam with id ' . $data->getExamId() . 'Does not exist.', 400);
            }

            $exam_result = new \Kpicaza\ExamBundle\Entity\ExamResult();

            $exam_result
                ->setExam($exam)
                ->setStartDatetime($data->getStartDatetime())
                ->setEndDatetime($data->getEndDatetime())
            ;

            return $exam_result;
        }

        throw new InvalidFormException('Invalid submitted data', $form);
    }

    /**
     * 
     * @param Form $form
     * @return type
     */
    public function parseFormErrors(Form $form)
    {
        $errors = $form->getErrors(true);
        $arr = array('errors' => array());
        foreach ($errors as $error) {
            $cause = $error->getCause();
            $arr['errors'][] = array(
              'field' => substr($cause->getPropertyPath(), strpos($cause->getPropertyPath(), '.') + 1),
              'message' => $cause->getMessage()
            );
        }

        return $arr;
    }

}
