<?php

namespace App\Form;

use App\Entity\Charge;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChargeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                "label" => "Titre",
                "label_attr" => ["class" => "form-label"],
                "attr" => [
                    "class" => "form-control"
                ]

            ])
            ->add('partSalarial', PercentType::class, [
                "label" => "Part Salarial",
                "label_attr" => ["class" => "form-label"],
                "attr" => ["class" => "form-control"],
            ])
            ->add('employerContribution', PercentType::class, [
                "label" => "Part Patronale",
                "label_attr" => ["class" => "form-label"],
                "attr" => ["class" => "form-control"]
            ])
            ->add('avantages', TextareaType::class, [
                "label" => "Avantages",
                "label_attr" => ["class" => "form-label"],
                "attr" => ["class" => "form-control"]
            ])
            ->add("submit", SubmitType::class, [
                "attr" => ["class" => "mt-2 btn btn-primary"],
                "label" => "Enregistrer"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Charge::class,
        ]);
    }
}
