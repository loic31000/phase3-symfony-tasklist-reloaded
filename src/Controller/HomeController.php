<?php

namespace App\Controller;

use App\Repository\FolderRepository;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    #[IsGranted('ROLE_USER')]
    public function index(FolderRepository $folderRepository, TaskRepository $taskRepository): Response
    {
        $folders = $folderRepository->findBy(['user' => $this->getUser()]);
        $tasks = $taskRepository->findBy(['user' => $this->getUser()], ['id' => 'DESC']);
        
        // Trier les tâches selon leur statut : en cours, terminée, archivée
        usort($tasks, function($a, $b) {
            return $a->getStatus()->getOrder() <=> $b->getStatus()->getOrder();
        });
        
        return $this->render('home/index.html.twig', [
            'folders' => $folders,
            'tasks' => $tasks,
        ]);
    }
}
