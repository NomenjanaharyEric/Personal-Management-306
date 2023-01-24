<?php

namespace App\Form;

use App\Entity\Charge;
use App\Entity\Contract;
use App\Entity\Employee;
use App\Entity\Tax;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContractType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,[
                "attr" => ["class" => "form-control"],
                "label" => "Titre",
                "label_attr" => [
                    "class" => "form-label"
                ]
            ])
            ->add('startDate', DateType::class, [
                "label" => "Date de Debut",
                "label_attr" => ["class" => "form-label"],
                "attr" => [
                    "class" => "form-control"
                ],
                "input" => "datetime_immutable"
            ])
            ->add('finishedDate', DateType::class, [
                "label" => "Date d'expiration",
                "label_attr" => ["class" => "form-label"],
                "attr" => [
                    "class" => "form-control"
                ],
                "input" => "datetime_immutable"
            ])
            ->add('type', ChoiceType::class, [
                "choices" => [
                    'CDD' => "CDD",
                    'CDI' => "CDI",
                    'STAGE' => "STAGE"
                ],
                "attr" => [
                    "class" => "form-control"
                ],
                "label" => "Type de contrat",
                "label_attr" => ["class" => "form-label"]
            ])
            ->add('status', ChoiceType::class, [
                "choices" => [
                    'Nouveau' => "NOUVEAU",
                    'En Cours' => "EN COURS",
                    'Terminer' => "TERMINER",
                    'Annuler' => "ANNULER",
                ],
                "label" => "Status",
                "label_attr" => ["class" => "form-label"],
                "attr" => ["class" => "form-control"]
            ])
            ->add('employee', EntityType::class, [
                "class" => Employee::class,
                "attr" => [
                    "class" => "form-control"
                ],
                "label" => "Employée",
                "label_attr" => ["class" => "form-label"]
            ])
            ->add("charges", EntityType::class,[
                "class" => Charge::class,
                "multiple" => true,
                "expanded" => true,
                "label" => "Charges",
                "required" => false,
                "attr" => ["class" => "form-check"],
                "label_attr" => ["class" => "form-check-label"],
            ])
            ->add("taxes", EntityType::class,[
                "class" => Tax::class,
                "multiple" => true,
                "expanded" => true,
                "label" => "Taxes",
                "required" => false,
                "attr" => ["class" => "form-check"],
                "label_attr" => ["class" => "form-check-label"],
            ])
            ->add("submit", SubmitType::class, [
                "attr" => ["class" => "btn btn-primary"],
                "label" => "Enregistrer"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contract::class,
        ]);
    }
}
