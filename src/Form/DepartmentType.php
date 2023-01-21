<?php

namespace App\Form;

use App\Entity\Department;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class DepartmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "attr" => [
                    'class' => "form-control",
                    'minlength' => '6',
                    'maxlength' => '255',
                ],
                'label' => 'Nom',
                'label_attr' => [
                    "class" => "form-label"
                ],
                "constraints" => [
                    new Assert\Length(['min' => 6, 'max' => 255]),
                    new Assert\NotNull()
                ]
            ])
            ->add('location', TextType::class, [
                "attr" => [
                    'class' => "form-control",
                    'minlength' => '6',
                    'maxlength' => '255',
                ],
                'label' => 'Location',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                "constraints" => [
                    new Assert\Length(['min' => 6, 'max' => 255]),
                    new Assert\NotNull()
                ]
            ])
            ->add('submit', SubmitType::class, [
                "attr" => [
                    "class" => " mt-2 btn btn-primary",
                ],
                "label" => "Enregistrer"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Department::class,
        ]);
    }
}
