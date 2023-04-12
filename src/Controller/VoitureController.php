<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Repository\VoitureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoitureController extends AbstractController
{
    #[Route('/admin/voiture', name: 'app_voiture_index', methods: ['GET'])]
    public function index(VoitureRepository $voitureRepository): Response
    {
        return $this->render('voiture/index.html.twig', [
            'voitures' => $voitureRepository->findAll(),
        ]);
    }

    #[Route('/voiture/new', name: 'app_voiture_new', methods: ['GET', 'POST'])]
    public function new(Request $request, VoitureRepository $voitureRepository): Response
    {
        $voiture = new Voiture();
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $voiture->setuser($this->getUser());
            $id = $voiture->getuser()->getId();
            $voitureRepository->save($voiture, true);
            return $this->redirectToRoute('app_voiture_showfr', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('voiture/new.html.twig', [
            'voiture' => $voiture,
            'form' => $form,
        ]);
    }

    #[Route('/admin/voiture/{immatriculation}', name: 'app_voiture_show', methods: ['GET'])]
    public function show(Voiture $voiture): Response
    {
        return $this->render('voiture/show.html.twig', [
            'voiture' => $voiture,
        ]);
    }

    #[Route('/voiture/voituser/{id}', name: 'app_voiture_showfr', methods: ['GET'])]
    public function showfr(VoitureRepository $voitureRepository, $id): Response
    {
        return $this->render('voiture/showfront.html.twig', [
            'voiture' => $voitureRepository->findByUser($id),
        ]);
    }

    #[Route('/voiture/edit/{id}', name: 'app_voiture_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, $id, VoitureRepository $voitureRepository): Response
    {
        $voiture = $voitureRepository->findByUser($id);
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $voitureRepository->save($voiture, true);
            return $this->redirectToRoute('app_voiture_showfr', ['id' => $voiture->getuser()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('voiture/edit.html.twig', [
            'voiture' => $voiture,
            'form' => $form,
        ]);
    }

    #[Route('/voiture/{immatriculation}', name: 'app_voiture_delete', methods: ['POST'])]
    public function delete(Request $request, Voiture $voiture, VoitureRepository $voitureRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $voiture->getImmatriculation(), $request->request->get('_token'))) {
            $id = $voiture->getuser()->getId();
            $voitureRepository->remove($voiture, true);
        }

        return $this->redirectToRoute('app_voiture_showfr', ['id' => $id], Response::HTTP_SEE_OTHER);
    }
}
