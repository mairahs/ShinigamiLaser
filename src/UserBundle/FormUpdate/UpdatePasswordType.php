<?php

namespace UserBundle\FormUpdate;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class UpdatePasswordType extends AbstractType
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($user) {
                $form = $event->getForm();
                if ("anon." !== $user) {
                    $form
                        ->add(
                            'oldPassword',
                            PasswordType::class,
                            [
                                'mapped' => false,
                                'label' => 'Ancien mot de passe',
                                'constraints' => array(
                                    new NotBlank()
                                )
                            ]
                        )
                    ;
                }
                $form->add(
                    'Modifier',
                    SubmitType::class
                );
            }
        );
        $builder
            ->add(
                'password',
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
                ]
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
