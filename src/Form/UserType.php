<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', TextType::class, [

                'label' => 'Nom:'
            ])
            ->add('firstname', TextType::class, [

                'label' => 'Prenom:'
            ])
            ->add('email', TextType::class)
            ->add('password', PasswordType::class, [

                'label' => 'Mot De Passe:'
            ])
            ->add('submit', SubmitType::class, [

                'label' => 'Créer',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
            ->add('reset', ResetType::class, [

                'label' => 'Recommencer',
                'attr' => [
                    'class' => 'btn btn-secondary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
