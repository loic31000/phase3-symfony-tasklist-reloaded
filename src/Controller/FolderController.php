<?php

namespace App\Controller;

use App\Entity\Folder;
use App\Form\FolderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class FolderController extends AbstractController
{
    #[Route('/folder/new', name: 'app_folder_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $folder = new Folder();
        $form = $this->createForm(FolderType::class, $folder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $folder->setUser($this->getUser());
            $entityManager->persist($folder);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('folder/new.html.twig', [
            'form' => $form,
        ]);
    }
}
