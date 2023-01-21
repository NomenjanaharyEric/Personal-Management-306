<?php

namespace App\Form;

use App\Entity\Department;
use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "attr" => [
                    "class" => "form-control",
                    "required" => true
                ],
                "label" => "Nom",
                "label_attr" => [
                    "class" => "form-label"
                ],
                "constraints" => [
                    new Assert\Length(['min' => 3, 'max' => 255]),
                    new Assert\NotNull()
                ]
            ])
            ->add('department', EntityType::class, [
                "class" => Department::class,
                "attr" => [
                    "class" => "form-control"
                ],
                "label" => "Departement",
                "label_attr" => [
                    "class" => "form-label"
                ],
                "constraints" => [
                    new Assert\NotNull()
                ]
            ])
            ->add("submit", SubmitType::class, [
                "attr" => [
                    "class" => "mt-2 btn btn-primary"
                ],
                "label" => "enregistrer"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
