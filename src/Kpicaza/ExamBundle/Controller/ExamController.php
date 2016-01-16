<?php

namespace Kpicaza\ExamBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Kpicaza\ExamBundle\Entity\Exam;
use Kpicaza\ExamBundle\Form\ExamType;

/**
 * Exam controller.
 *
 */
class ExamController extends Controller
{
    /**
     * Lists all Exam entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $exams = $em->getRepository('KpicazaExamBundle:Exam')->findAll();

        return $this->render('exam/index.html.twig', array(
            'exams' => $exams,
        ));
    }

    /**
     * Creates a new Exam entity.
     *
     */
    public function newAction(Request $request)
    {
        $exam = new Exam();
        $form = $this->createForm('Kpicaza\ExamBundle\Form\ExamType', $exam);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($exam);
            $em->flush();

            return $this->redirectToRoute('exam_show', array('id' => $exam->getId()));
        }

        return $this->render('exam/new.html.twig', array(
            'exam' => $exam,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Exam entity.
     *
     */
    public function showAction(Exam $exam)
    {
        $deleteForm = $this->createDeleteForm($exam);

        return $this->render('exam/show.html.twig', array(
            'exam' => $exam,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Exam entity.
     *
     */
    public function editAction(Request $request, Exam $exam)
    {
        $deleteForm = $this->createDeleteForm($exam);
        $editForm = $this->createForm('Kpicaza\ExamBundle\Form\ExamType', $exam);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($exam);
            $em->flush();

            return $this->redirectToRoute('exam_edit', array('id' => $exam->getId()));
        }

        return $this->render('exam/edit.html.twig', array(
            'exam' => $exam,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Exam entity.
     *
     */
    public function deleteAction(Request $request, Exam $exam)
    {
        $form = $this->createDeleteForm($exam);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($exam);
            $em->flush();
        }

        return $this->redirectToRoute('exam_index');
    }

    /**
     * Creates a form to delete a Exam entity.
     *
     * @param Exam $exam The Exam entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Exam $exam)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('exam_delete', array('id' => $exam->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
