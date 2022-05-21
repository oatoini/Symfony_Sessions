<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\Session;
use App\Entity\Programme;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProgrammeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('duree', NumberType::class)
            ->add('session', EntityType::class, [
                'class' => Session::class,
                'choice_label' => 'nom'
            ])
            ->add('cours', EntityType::class, [
                'class' => Cours::class,
                'choice_label' => 'nom'
            ])
            ->add('valider', SubmitType::class , [
                'attr' => ['class'=>'btn btn-secondary']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Programme::class,
        ]);
    }
}
