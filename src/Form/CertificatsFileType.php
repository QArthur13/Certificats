<?php

namespace App\Form;

use App\Entity\Certificats;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

/**
 * Cette classe envoie une extension de x509 pour pouvoir ensuite être envoyer dans le form.
 */
class CertificatsFileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('certificats', FileType::class, [
                
                'label' => 'Analyse du certificats',

                //On asssocie pas notre fichier à n'importe quelle propriété d'une entité.
                'mapped' => false,

                //Obligation de mettre un fichier avec un certificats.
                'required' => true,

                //Ici nous allons mettre nos contraintes.
                /* 'constraints' => [

                    new File([

                        'mimeTypes' => [

                            'application/x-x509-ca-cert',
                            'application/x-x509-ca-ra-cert',
                            'application/x-x509-next-ca-cert',
                        ],

                        'mimeTypesMessage' => 'Veuillez mettre un certificats valide, merci.',
                    ])
                    ], */
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Certificats::class,
        ]);
    }
}
