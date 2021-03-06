<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
                'playedAt',
                DateTimeType::class,
                array(
        'widget' => 'single_text',
        'html5' => false,
        'attr' => [
            'class' => 'datepicker_2',
            'placeholder' => '31/12/2017',
        ],
        'format' => 'dd/MM/yyyy',
    )
            )
            ->add('gameType', null, ['placeholder' => 'Choisissez un type de partie'])
            ->add('timeSlot', null, ['placeholder' => 'Choisissez une plage horaire'])
            ->add('etablishment', null, ['placeholder' => 'Choisissez un établissement'])
            ->add('nbMax', TextType::class)
            ->add('Ajouter', SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Game',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_game';
    }
}
