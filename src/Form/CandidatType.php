<?php

namespace App\Form;

use App\Entity\Candidat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidatType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        switch ($options["etapes"]){
            case 'edit_profile':
                $this->addCandidat($builder);
                break;
            default:
                $this->addCandidat($builder);
                $this->candidatCV($builder);

        }
    }

    private function addCandidat(FormBuilderInterface $builder){
        $builder
            ->add('lastname', TextType::class, [
                'required' => true,
                'label' => 'Nom*',
                'attr' => [
                    'placeholder' => 'Votre nom'
                ]
            ])
            ->add('firstname', TextType::class, [
                'required' => true,
                'label' => 'Prénom*',
                'attr' => [
                    'placeholder' => 'Votre prénom'
                ]
            ])
            ->add('phone', TextType::class, [
                'required' => true,
                'label' => 'Téléphone *',
                'attr' => [
                    'placeholder' => 'Votre téléphone'
                ]
            ])
            ->add('email', TextType::class, [
                'required' => true,
                'label' => 'Email *',
                'attr' => [
                    'placeholder' => 'Votre email'
                ]
            ]);

        return $builder;

    }


    private function candidatCV(FormBuilderInterface $builder){
        $builder
            ->add('candidat_cv', FileType::class, [
                'required' => true,
                'label' => 'Votre CV*',
                'mapped' => false
            ]);
        return $builder;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidat::class,
            'etapes' => null
        ]);
    }
}
