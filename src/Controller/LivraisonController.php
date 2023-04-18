<?php

namespace App\Controller;

use App\Entity\Livraison;
use App\Form\LivraisonType;
use App\Repository\LivraisonRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class LivraisonController extends AbstractController
{
    #[Route('/livraison', name: 'app_livraison_index', methods: ['GET'])]
    public function index(LivraisonRepository $livraisonRepository): Response
    {

        $livraisons = $livraisonRepository->findAll();

        return $this->render('livraison/index.html.twig', [
            'livraisons' => $livraisons,
        ]);
    }

    #[Route('/livraison/new', name: 'app_livraison_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UtilisateurRepository $userRepo, LivraisonRepository $livraisonRepository): Response
    {
        $livraison = new Livraison();
        $form = $this->createForm(LivraisonType::class, $livraison);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $livraison->setEtat("En attente");
            $livraison->setIdClient($this->getUser());
            $id = $livraison->getClient()->getId();
            $livraisonRepository->save($livraison, true);

            return $this->redirectToRoute('app_livraison_byuser', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('livraison/new.html.twig', [
            'livraison' => $livraison,
            'form' => $form,
        ]);
    }




    #[Route('/livraison/{id}', name: 'app_livraison_byuser', methods: ['GET'])]
    public function showfr(LivraisonRepository $livraisonRepository, $id): Response
    {

        return $this->render('livraison/list.html.twig', [
            'livraisons' => $livraisonRepository->findByUser($id),
        ]);
    }




    #[Route('/livraison/{idLivraison}', name: 'app_livraison_show', methods: ['GET'])]
    public function show(Livraison $livraison): Response
    {
        return $this->render('livraison/show.html.twig', [
            'livraison' => $livraison,
        ]);
    }

    #[Route('/livraison/{idLivraison}/edit', name: 'app_livraison_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Livraison $livraison, LivraisonRepository $livraisonRepository): Response
    {
        $form = $this->createForm(LivraisonType::class, $livraison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $livraisonRepository->save($livraison, true);

            return $this->redirectToRoute('app_livraison_byuser', ['id' => $livraison->getIdClient()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('livraison/edit.html.twig', [
            'livraison' => $livraison,
            'form' => $form,
        ]);
    }

    // #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    // public function delete(Request $request, User $user, UserRepository $userRepository): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
    //         $userRepository->remove($user, true);
    //     }

    //     return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    // }

    // #[Route('/livraison/{idLivraison}/delete', name: 'app_livraison_delete',methods: ['POST'])]
    // public function delete(Request $request, int $idLivraison, EntityManagerInterface $entityManager): RedirectResponse
    // {
    //     $livraison = $entityManager->getRepository(Livraison::class)->find($idLivraison);
    //     if ($livraison) {
    //         $entityManager->remove($livraison);
    //         $entityManager->flush();
    //         $this->addFlash(type: 'SUCCESS', message: "La livraison a été supprimée avec succès");
    //     } else {
    //         $this->addFlash(type: 'error', message: "Livraison n'existe pas !");
    //     }
    //     return $this->redirectToRoute('app_livraison_byuser', ['id' => $livraison->getIdClient()->getId()], Response::HTTP_SEE_OTHER);
    // }


    #[Route('/livraison/delete/{id}', name: 'app_livraison_delete')]
    public function delete(Request $request,  Livraison $livraison = null, ManagerRegistry $doctrine): RedirectResponse

    {

        $manager = $doctrine->getManager();
        $manager->remove($livraison);
        $manager->flush();

        return $this->redirectToRoute('app_livraison_byuser', ['id' => $livraison->getIdClient()->getId()], Response::HTTP_SEE_OTHER);
    }
}
