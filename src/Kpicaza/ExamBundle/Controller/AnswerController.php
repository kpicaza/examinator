<?php

namespace Kpicaza\ExamBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Kpicaza\ExamBundle\Entity\Answer;
use Kpicaza\ExamBundle\Form\AnswerType;

/**
 * Answer controller.
 *
 */
class AnswerController extends Controller
{
    /**
     * Lists all Answer entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $answers = $em->getRepository('KpicazaExamBundle:Answer')->findAll();

        return $this->render('answer/index.html.twig', array(
            'answers' => $answers,
        ));
    }

    /**
     * Creates a new Answer entity.
     *
     */
    public function newAction(Request $request)
    {
        $answer = new Answer();
        $form = $this->createForm('Kpicaza\ExamBundle\Form\AnswerType', $answer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($answer);
            $em->flush();

            return $this->redirectToRoute('answer_show', array('id' => $answer->getId()));
        }

        return $this->render('answer/new.html.twig', array(
            'answer' => $answer,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Answer entity.
     *
     */
    public function showAction(Answer $answer)
    {
        $deleteForm = $this->createDeleteForm($answer);

        return $this->render('answer/show.html.twig', array(
            'answer' => $answer,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Answer entity.
     *
     */
    public function editAction(Request $request, Answer $answer)
    {
        $deleteForm = $this->createDeleteForm($answer);
        $editForm = $this->createForm('Kpicaza\ExamBundle\Form\AnswerType', $answer);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($answer);
            $em->flush();

            return $this->redirectToRoute('answer_edit', array('id' => $answer->getId()));
        }

        return $this->render('answer/edit.html.twig', array(
            'answer' => $answer,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Answer entity.
     *
     */
    public function deleteAction(Request $request, Answer $answer)
    {
        $form = $this->createDeleteForm($answer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($answer);
            $em->flush();
        }

        return $this->redirectToRoute('answer_index');
    }

    /**
     * Creates a form to delete a Answer entity.
     *
     * @param Answer $answer The Answer entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Answer $answer)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('answer_delete', array('id' => $answer->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
