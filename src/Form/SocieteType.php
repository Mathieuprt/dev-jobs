<?php

namespace App\Form;

use App\Entity\Societe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SocieteType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        switch ($options['etapes']){
            case 'edit_profil':
                $this->editLogo($builder);
                $this->editProfil($builder);
                break;
            default:
                $this->addSociete($builder);
        }
    }

    private function addSociete(FormBuilderInterface $builder){
        $builder
            ->add('background_logo', ColorType::class, [
                'required' => false,
                'label' => 'Couleur de fond du logo'
            ])
            ->add('logo', FileType::class, [
                'required' => true,
                'label' => 'Logo',
                'mapped' => false
            ]);
        $this->editProfil($builder);

        return $builder;
    }

    private function editLogo(FormBuilderInterface $builder){
        $builder
            ->add('background_logo', ColorType::class, [
                'required' => false,
                'label' => 'Couleur de fond du logo'
            ])
            ->add('logo', FileType::class, [
                'required' => true,
                'label' => 'Logo',
                'mapped' => false
            ]);

        return $builder;
    }

    private function editProfil(FormBuilderInterface $builder){
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Nom *',
                'attr' => [
                    'placeholder' => 'Nom de la société'
                ]
            ])
            ->add('city', TextType::class, [
                'required' => true,
                'label' => 'Ville *',
                'attr' => [
                    'placeholder' => 'Ville de la société'
                ]
            ])
            ->add('website', TextType::class, [
                'required' => true,
                'label' => 'Site de la société *',
                'attr' => [
                    'placeholder' => 'Adresse URL du site'
                ]
            ])
            ->add('lastname_contact', TextType::class, [
                'required' => true,
                'label' => 'Nom du contact *',
                'attr' => [
                    'placeholder' => 'Nom'
                ]
            ])
            ->add('firstname_contact', TextType::class, [
                'required' => true,
                'label' => 'Prénom du contact *',
                'attr' => [
                    'placeholder' => 'Prénom'
                ]
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => 'Email du contact *',
                'attr' => [
                    'placeholder' => 'Email'
                ]
            ])
            ->add('phone_contact', TextType::class, [
                'required' => true,
                'label' => 'Téléphone du contact *',
                'attr' => [
                    'placeholder' => 'Numéro de téléphone'
                ]
            ])
            ->add('login', TextType::class, [
                'required' => true,
                'label' => 'Identifiant *',
                'attr' => [
                    'placeholder' => 'Votre identifiant'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Vos mots de passe ne correspondent pas',
                'first_options' => [
                    'label' => 'Mot de passe *'
                ],
                'second_options' => [
                    'label' => 'Confirmation du mot de passe*'
                ]
            ]);

        return $builder;
    }

    /*
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('login')
            ->add('roles')
            ->add('password')
            ->add('name')
            ->add('logo')
            ->add('background_logo')
            ->add('city')
            ->add('website')
            ->add('firstname_contact')
            ->add('lastname_contact')
            ->add('email')
            ->add('phone_contact')
        ;
    }*/

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Societe::class,
            'etapes' => null
        ]);
    }
}
