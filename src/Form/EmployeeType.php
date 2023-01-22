<?php

namespace App\Form;

use App\Entity\Employee;
use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class EmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('matricule', TextType::class, [
                "attr" => [
                    "class" => "form-control",
                    "required" => true,
                    "minlength" => '4'
                ],
            ])
            ->add('name', TextType::class, [
                "attr" => [
                    "class" => "form-control",
                    "required" => true,
                    "minlength" => "3",
                    "maxlength" => "255"
                ],
                "label" => "Nom",
                "label_attr" => ["class" => "form-label"],
                "constraints" => [
                    new Assert\NotNull(),
                    new Assert\Length(["min" =>3, "max" => 255])
                ]
            ])
            ->add('lastname', TextType::class, [
                "attr" => [
                    "class" => "form-control",
                    "required" => true,
                    "minlength" => "3",
                    "maxlength" => "255"
                ],
                "label" => "Prenom",
                "label_attr" => ["class" => "form-label"],
                "constraints" => [
                    new Assert\NotNull(),
                    new Assert\Length(["min" =>3, "max" => 255])
                ]
            ])
            ->add('dateOfBirth', BirthdayType::class, [
                "attr" => ["class" => "form-control"],
                "label" => "Date de Naissance",
                "label_attr" => ["class" => "form-label"],
                "input" => "datetime_immutable"
            ])
            ->add('sexe', ChoiceType::class, [
                "choices" => [
                    "Femme" => 0,
                    "Homme" => 1
                ],
                "attr" => ["class" => "form-control"],
                "label" => "Sexe",
                "label_attr" => ["class" => "form-label"]
            ])
            ->add('nationality', TextType::class , [
                "attr" => [
                    "class" => "form-control",
                    "required" => true,
                ],
                "label" => "Nationalite",
                "label_attr" => ["class" => "form-label"]
            ])
            ->add('phone', TelType::class, [
                "attr" => [
                    "class" => "form-control",
                    "required" => true,
                ],
                "label" => "Telephone",
                "label_attr" => ["class" => "form-label"],
                "constraints" => [
                    new Assert\NotNull(),
                    new Assert\Length(["min" =>3, "max" => 255])
                ]
            ])
            ->add('cin', TextType::class, [
                "attr" => [
                    "class" => "form-control",
                    "required" => true,
                    "minlength" => "10",
                    "maxlength" => "20"
                ],
                "label" => "CIN",
                "label_attr" => ["class" => "form-label"],
                "constraints" => [
                    new Assert\NotNull(),
                    new Assert\Length(["min" =>10, "max" => 20])
                ]
            ])
            ->add('familyStatus', TextType::class, [
                "attr" => [
                    "class" => "form-control",
                    "minlength" => "3",
                    "maxlength" => "255",
                    "required" => true
                ],
                "label" => "Status Familliale",
                "label_attr" => ["class" => "form-label"],
                "constraints" => [
                    new Assert\NotNull(),
                    new Assert\Length(["min" => 3, "max" => 255]),
                ]
            ])
            ->add('email', EmailType::class, [
                "attr" => ["class" => "form-control"],
                "constraints" => [
                    new Assert\NotNull(),
                    new Assert\Email()
                ]
            ])
            ->add('service', EntityType::class, [
                "class" => Service::class,
                "attr" => ["class" => "form-control"],
                "label" => "Service",
                "label_attr" => ["class" => "form-label"]
            ])
            ->add("submit", SubmitType::class, [
                "attr" => ["class" => " mt-2 mb-5 btn btn-primary"],
                "label" => "Enregistrer"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employee::class,
        ]);
    }
}
