<?php

namespace App\Form;

use App\Entity\Car;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            # ->add('image')
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class'=> 'form-control mb-3',
                    'minlength' => '100',
                    'maxlength' => '500',
                ],
                'label' => 'Description',
                'label_attr' => [
                    'class' => 'form-label ',
                ],
                'constraints' => [
                    new Assert\Length(['min' => 100, 'max' => 500]),
                    new Assert\NotBlank()
                ]
            ])

            ->add('price', MoneyType::class, [
                'attr' => [
                    'class'=> 'form-control mb-3',
                ],
                'label' => 'Prix: ',
                'label_attr' => [
                    'class' => 'form-label ',
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Positive(),
                ]
            ])

            ->add('yearOfManufacture', DateType::class, [
                'attr' => [
                    'class'=> 'form-control mb-3',
                ],
                'widget' => 'single_text',
                'label' => 'Année de mise en circulation: ',
                'label_attr' => [
                    'class' => 'form-label ',
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                ]
            ])

            ->add('mileage', NumberType::class, [
                'attr' => [
                    'class'=> 'form-control mb-5',
                ],
                'label' => 'Kilométrage: ',
                'label_attr' => [
                    'class' => 'form-label ',
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Positive(),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary custom-btn-width'
                ],
                'label' => 'Envoyer'
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
