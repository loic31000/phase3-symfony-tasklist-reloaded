<?php

namespace App\Form;

use App\Config\TaskStatus;
use App\Entity\Folder;
use App\Entity\Priority;
use App\Entity\Task;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user'];

        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de la tâche',
                'attr' => ['placeholder' => 'Ex: Finir le rapport']
            ])
            ->add('priority', EntityType::class, [
                'class' => Priority::class,
                'choice_label' => 'name',
                'label' => 'Priorité',
                'placeholder' => 'Choisir une priorité',
                'query_builder' => function ($repository) use ($user) {
                    return $repository->createQueryBuilder('p')
                        ->where('p.user IS NULL OR p.user = :user')
                        ->setParameter('user', $user)
                        ->orderBy('p.importance', 'ASC');
                },
            ])
            ->add('folder', EntityType::class, [
                'class' => Folder::class,
                'choice_label' => 'name',
                'label' => 'Dossier',
                'placeholder' => 'Aucun dossier',
                'required' => false,
                'query_builder' => function ($repository) use ($user) {
                    return $repository->createQueryBuilder('f')
                        ->where('f.user = :user')
                        ->setParameter('user', $user);
                },
            ])
            ->add('status', EnumType::class, [
                'label' => 'Statut',
                'class' => TaskStatus::class,
                'choice_label' => fn(TaskStatus $status) => $status->getLabel(),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
            'user' => null,
        ]);

        $resolver->setRequired('user');
        $resolver->setAllowedTypes('user', [User::class, 'null']);
    }
}
