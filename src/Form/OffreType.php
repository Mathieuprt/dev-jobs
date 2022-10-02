<?php

namespace App\Form;

use App\Entity\Offres;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OffreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => 'Intitulé du poste',
                'attr' => [
                    'placeholder' => 'Intitulé" du poste'
                ]
            ])
            ->add('contrat_type', ChoiceType::class, [
                'required' => true,
                'label' => 'Type du contrat',
                "choices" => [
                    'CDI' => 'CDI',
                    'CDD' => 'CDD',
                    'Stage' => 'Stage',
                    'Alternance' => 'Alternance,'
                ]
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'label' => 'Description courte du poste',
                'attr'=> [
                    'placeholder' => 'Description courte'
                ]
            ])
            ->add('profil_desc', TextareaType::class, [
                'required' => true,
                'label' => 'Description du profil',
                'attr'=> [
                    'placeholder' => 'Description du profil'
                ]
            ])
            ->add('profil_comp', TextType::class, [
                'required' => true,
                'label' => 'Compétences du profil',
                'attr'=> [
                    'placeholder' => 'Compétences requises'
                ]
            ])
            ->add('poste_desc', TextareaType::class, [
                'required' => true,
                'label' => 'Description du poste',
                'attr'=> [
                    'placeholder' => 'Description'
                ]
            ])
            ->add('poste_mission', TextareaType::class, [
                'required' => true,
                'label' => 'Missions du poste',
                'attr'=> [
                    'placeholder' => 'Missions'
                ]
            ])
            ->add('website', TextType::class, [
                'required' => true,
                'label' => 'Site de la societé',
                'attr'=> [
                    'placeholder' => 'Adresse URL du site'
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offres::class,
        ]);
    }
}
