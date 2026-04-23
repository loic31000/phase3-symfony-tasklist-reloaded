<?php

namespace App\Controller;

use App\Entity\Priority;
use App\Form\PriorityType;
use App\Repository\PriorityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class PriorityController extends AbstractController
{
    #[Route('/priority/new', name: 'app_priority_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $priority = new Priority();
        $form = $this->createForm(PriorityType::class, $priority);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $priority->setUser($this->getUser());
            $entityManager->persist($priority);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('priority/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/priority/list', name: 'app_priority_list')]
    public function list(PriorityRepository $priorityRepository): Response
    {
        $priorities = $priorityRepository->findBy([
            'user' => $this->getUser()
        ]);

        return $this->render('priority/list.html.twig', [
            'priorities' => $priorities,
        ]);
    }
}
