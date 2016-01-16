<?php

namespace Kpicaza\ExamBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExamResultType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_format', 'hidden')
            ->add('exam_id', 'number', array(
              'required' => true
            ))
            ->add('start_datetime', 'datetime')
            ->add('end_datetime', 'datetime', array(
              'required' => false
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
          'data_class' => 'Kpicaza\ExamBundle\Form\Model\ExamResultFormModel',
          'csrf_protection' => false,
        ));
    }

}
