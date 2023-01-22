<?php

namespace App\Form;

use App\Entity\Job;
use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class JobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                "attr" => [
                    "class" => "form-control",
                    "required" => true,
                ],
                "label" => "Titre",
                "label_attr" => [
                    "class" => "form-label"
                ],
                "constraints" => [
                    new Assert\NotNull(),
                    new Assert\Length(['min' => 4, 'max' => 255])
                ]
            ])
            ->add('baseSalary', MoneyType::class, [
                "attr" => [
                    "class" => "form-control",
                    "required" => true,
                ],
                "label" => "Salaire de Base",
                "label_attr" => [
                    "class" => "form-label"
                ],
                "constraints" => [
                    new Assert\NotNull(),
                    new Assert\Positive()
                ]
            ])
            ->add('workHours', IntegerType::class, [
                "attr" => [
                    "class" => "form-control",
                    "required" => true,
                    "min" => 1
                ],
                "label" => "Heure de Travail par mois",
                "label_attr" => [
                    "class" => "form-label"
                ],
                "constraints" => [
                    new Assert\NotNull(),
                    new Assert\Positive(),
                    new Assert\LessThan(576)
                ]
            ])
            ->add('description', TextareaType::class, [
                "attr" => ["class" => "form-control", "required" => true],
                "label" => "Description",
                "label_attr" => ["class" => "form-label"],
                "constraints" => [
                    new Assert\NotNull(),
                    new Assert\Length(['min' => 10])
                ]
            ])
            ->add('service', EntityType::class, [
                "class" => Service::class,
                "attr" => ["class" => "form-control"]
            ])
            ->add('submit', SubmitType::class, [
                "attr" => ["class" => "mt-2 btn btn-primary"],
                "label" => "Enregistrer"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Job::class,
        ]);
    }
}
