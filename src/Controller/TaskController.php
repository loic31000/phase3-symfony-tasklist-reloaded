<?php

namespace App\Controller;

use App\Config\TaskStatus;
use App\Entity\Task;
use App\Form\TaskType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class TaskController extends AbstractController
{
    #[Route('/task/new', name: 'app_task_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $task = new Task();
        $task->setStatus(TaskStatus::EN_COURS);
        $task->setIsPinned(false);
        
        $form = $this->createForm(TaskType::class, $task, [
            'user' => $this->getUser()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task->setUser($this->getUser());
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('task/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/task/{id}', name: 'app_task_show')]
    public function show(Task $task): Response
    {
        // Vérifier que l'utilisateur est propriétaire
        if ($task->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('task/show.html.twig', [
            'task' => $task,
        ]);
    }

    #[Route('/task/{id}/edit', name: 'app_task_edit')]
    public function edit(Request $request, Task $task, EntityManagerInterface $entityManager): Response
    {
        // Vérifier que l'utilisateur est propriétaire
        if ($task->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(TaskType::class, $task, [
            'user' => $this->getUser()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form,
            'task' => $task,
        ]);
    }

    #[Route('/task/{id}/delete', name: 'app_task_delete', methods: ['POST'])]
    public function delete(Request $request, Task $task, EntityManagerInterface $entityManager): Response
    {
        // Vérifier que l'utilisateur est propriétaire
        if ($task->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        if ($this->isCsrfTokenValid('delete'.$task->getId(), $request->request->get('_token'))) {
            $entityManager->remove($task);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_home');
    }

    #[Route('/task/{id}/toggle-status', name: 'app_task_toggle_status', methods: ['POST'])]
    public function toggleStatus(Request $request, Task $task, EntityManagerInterface $entityManager): JsonResponse
    {
        // Vérifier que l'utilisateur est propriétaire
        if ($task->getUser() !== $this->getUser()) {
            return new JsonResponse(['error' => 'Access denied'], 403);
        }

        $data = json_decode($request->getContent(), true);
        $completed = $data['completed'] ?? false;

        // Changer le statut selon la checkbox
        if ($completed) {
            $task->setStatus(TaskStatus::TERMINEE);
        } else {
            $task->setStatus(TaskStatus::EN_COURS);
        }

        $entityManager->flush();

        return new JsonResponse([
            'success' => true,
            'status' => $task->getStatus()->value,
            'label' => $task->getStatus()->getLabel()
        ]);
    }
}
