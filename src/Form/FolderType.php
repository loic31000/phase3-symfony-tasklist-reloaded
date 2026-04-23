<?php

namespace App\Form;

use App\Entity\Folder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FolderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['placeholder' => 'Ex: Travail']
            ])
            ->add('color', ChoiceType::class, [
                'choices' => [
                    '#EF4444' => '#EF4444', // red
                    '#F97316' => '#F97316', // orange
                    '#F59E0B' => '#F59E0B', // amber
                    '#EAB308' => '#EAB308', // yellow
                    '#84CC16' => '#84CC16', // lime
                    '#22C55E' => '#22C55E', // green
                    '#10B981' => '#10B981', // emerald
                    '#14B8A6' => '#14B8A6', // teal
                    '#06B6D4' => '#06B6D4', // cyan
                    '#3B82F6' => '#3B82F6', // blue
                    '#6366F1' => '#6366F1', // indigo
                    '#8B5CF6' => '#8B5CF6', // violet
                    '#A855F7' => '#A855F7', // purple
                    '#D946EF' => '#D946EF', // fuchsia
                    '#EC4899' => '#EC4899', // pink
                ],
                'expanded' => true,
                'multiple' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Folder::class,
        ]);
    }
}
