<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IndicateurType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelleIndicateur')
<<<<<<< HEAD
<<<<<<< HEAD
            ->add('typeIndicateur','entity',array(
                'class' => 'AppBundle:TypeIndicateur',
                'required' => false,
            ))
=======
            /*->add('typeIndicateur','entity',array(
                    'class' => 'AppBundle:TypeIndicateur',
                    'property' => 'libelleTypeIndicateur'
                ))*/
            ->add('typeIndicateur',new TypeIndicateurType())
>>>>>>> 5f2827c1e2ae703d65f3535886744be7aae4ee85
=======

>>>>>>> 5cc51e559f7d061feabada8ac011b5fb73db728a
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Indicateur',
            'csrf_protection' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'indicateur';
    }
}
