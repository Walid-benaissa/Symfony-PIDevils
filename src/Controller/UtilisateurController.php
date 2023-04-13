<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\Voiture;
use App\Form\CreerCompteType;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UtilisateurController extends AbstractController
{
    #[Route('/login', name: 'app_utilisateur_login', methods: ['GET', 'POST'])]
    public function login(): Response
    {
        return $this->renderForm('utilisateur/login.html.twig', []);
    }

    #[Route('/admin/utilisateur', name: 'app_utilisateur_index', methods: ['GET'])]
    public function index(UtilisateurRepository $utilisateurRepository): Response
    {
        $user = $this->getUser();
        return $this->render('utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateurRepository->findAll(),
            'user' => $user
        ]);
    }

    #[Route('/creatCpt', name: 'app_utilisateur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UtilisateurRepository $utilisateurRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $passwordHasher->hashPassword(
                $utilisateur,
                $utilisateur->getmdp()
            );
            $utilisateur->setMdp($hashedPassword);
            $utilisateurRepository->save($utilisateur, true);

            return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('utilisateur/creatCpt.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/admin/utilisateur/{id}', name: 'app_utilisateur_show', methods: ['GET'])]
    public function show(Utilisateur $utilisateur): Response
    {
        return $this->render('utilisateur/show.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }
    #[Route('/utilisateur/{id}', name: 'app_utilisateur_showfr', methods: ['GET'])]
    public function showfr(Utilisateur $utilisateur): Response
    {
        return $this->render('utilisateur/showfront.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }

    #[Route('/admin/utilisateuredit/{id}', name: 'app_utilisateur_editb', methods: ['GET', 'POST'])]
    public function editB(Request $request, Utilisateur $utilisateur, UtilisateurRepository $utilisateurRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $voiture = new Voiture;
        $voiture->setuser($this->getUser());
        $id = $voiture->getuser()->getId();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $passwordHasher->hashPassword(
                $utilisateur,
                $utilisateur->getmdp()
            );
            $utilisateur->setMdp($hashedPassword);
            $utilisateurRepository->save($utilisateur, true);

            return $this->redirectToRoute('app_utilisateur_editb', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('utilisateur/edit.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }
    #[Route('/utilisateur/{id}/edit/', name: 'app_utilisateur_edit', methods: ['GET', 'POST'])]

    public function edit(Request $request, Utilisateur $utilisateur, UtilisateurRepository $utilisateurRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $passwordHasher->hashPassword(
                $utilisateur,
                $utilisateur->getmdp()
            );
            $utilisateur->setMdp($hashedPassword);
            $utilisateurRepository->save($utilisateur, true);

            return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('utilisateur/editfront.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }

    #[Route('/admin/utilisateur/{id}', name: 'app_utilisateur_delete', methods: ['POST'])]
    public function delete(Request $request, Utilisateur $utilisateur, UtilisateurRepository $utilisateurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $utilisateur->getId(), $request->request->get('_token'))) {
            $utilisateurRepository->remove($utilisateur, true);
        }

        return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
    }
}
