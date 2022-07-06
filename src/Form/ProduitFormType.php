<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Titre du produit'
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Description du produit'
                ]
            ])
            ->add('color', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Couleur du produit'
                ],
            ])
            ->add('size', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'S' => 'small',
                    'M' => 'medium',
                    'L' => 'large'
                ],
                //                'choice_label' => 'Taille'
            ])
            ->add('collection', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Collection homme ou femme'
                ],
            ])
            ->add('price', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Prix €'
                ],
            ])
            ->add('stock', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Quantité en stock'
                ],
            ])
            ->add('photo', FileType::class, [
                'label' => "Photo du produit",
                //                'data_class' => null,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter',
                'validate' => false,
                'attr' => [
                    'class' => 'd-block mx-auto col-3 btn btn-success'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
