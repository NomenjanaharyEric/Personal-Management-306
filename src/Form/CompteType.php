<?php

namespace App\Form;

use App\Entity\Compte;
use App\Entity\Employee;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero', TextType::class, [
                "label" => "Numero",
                "label_attr" => ["class" => "form-label"],
                "attr" => ["class" => "form-control"]
            ])
            ->add('solde', MoneyType::class, [
                "label" => "Solde",
                "label_attr" => ["class" => "form-label"],
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('owner', EntityType::class, [
                "class" => Employee::class,
                "attr" => [
                    "class" => "form-control"
                ],
                "label" => "Propriétaire",
                "label_attr" => ["class" => "form-label"]
            ])
            ->add("submit", SubmitType::class, [
                "label" => "Enregistrer",
                "attr" => [
                    "class" => " mt-2 btn btn-primary"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Compte::class,
        ]);
    }
}
