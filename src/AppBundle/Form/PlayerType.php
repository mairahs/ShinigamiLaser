<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlayerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname', TextType::class)
                ->add('lastname', TextType::class)
                ->add('username', TextType::class)
                ->add('address', TextareaType::class)
                ->add('phoneNumber', TextType::class)
                ->add('dateOfBirth',  BirthdayType::class, ['placeholder'=>['day'=>'Day', 'month'=>'Month', 'year'=>'Year'], 'label_attr' => ['class' => 'label-dob']])
                ->add('email', EmailType::class)
                ->add('password', RepeatedType::class, ['type'=>PasswordType::class, 'first_options'=>['label'=>'Password'], 'second_options'=>['label'=>'Repeat Password']])
                ->add('avatar', AvatarType::class)
                ->add('Enregistrez-vous',SubmitType::class);
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
