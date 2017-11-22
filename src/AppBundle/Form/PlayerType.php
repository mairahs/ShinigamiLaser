<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PlayerType extends AbstractType
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
        $builder
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('username', TextType::class)
            ->add('address', TextareaType::class)
            ->add('phoneNumber', TextType::class)
            ->add(
                'dateOfBirth',
                DateType::class,
                array(
                    'widget' => 'single_text',
                    'html5' => false,
                    'attr' => [
                        'class' => 'datepicker',
                        'placeholder' => '31/12/2017',
                    ],
                    'format' => 'dd/MM/yyyy',
                )
            )
            ->add('email', EmailType::class)
        ;
        $user = $this->tokenStorage->getToken()->getUser();
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($user) {
                $form = $event->getForm();
                if ("anon." === $user) {
                    $form
                        ->add('password', RepeatedType::class, ['type'=>PasswordType::class, 'first_options'=>['label'=>'Password'], 'second_options'=>['label'=>'Confirm password']])
                        ->add('avatar', AvatarType::class)
                        ->add('Enregistrez-vous', SubmitType::class)
                    ;
                } else {
                    $form
                        ->add('Modifier', SubmitType::class)
                    ;
                }
            }
        );
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
        return 'appbundle_player';
    }
}
