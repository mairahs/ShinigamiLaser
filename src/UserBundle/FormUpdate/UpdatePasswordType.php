<?php

namespace UserBundle\FormUpdate;


use AppBundle\Form\AvatarType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class UpdatePasswordType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword',
                TextType::class,
                [
                    'mapped' => false,
                    'label' => 'Ancien mot de passe',
                    'constraints' => array(
                        new NotBlank()
                    )
                ]
            )
            ->add('password',
                RepeatedType::class,
                [
                    'type'=>PasswordType::class,
                    'first_options' =>
                        [
                            'label' => 'Password'
                        ],
                    'second_options' =>
                        [
                            'label' => 'Confirm password'
                        ]
                ])
            ->add('Modifier',
                SubmitType::class
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Player'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'userbundle_password';
    }

}