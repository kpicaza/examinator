<?php

namespace Kpicaza\ExamBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FilterFormType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('exam_id', 'number', array(
              'required' => false,
            ))
            ->add('limit', 'number', array(
              'required' => true,
            ))
            ->add('offset', 'number', array(
              'required' => true
            ))
            ->add('since', 'text')
            ->add('keywords', 'text')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
          'data_class' => 'Kpicaza\ExamBundle\Form\Model\FilterFormModel',
          'csrf_protection' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'rest_filter';
    }

}
