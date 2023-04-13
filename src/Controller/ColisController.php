<?php

namespace App\Controller;

use App\Entity\Colis;
use App\Form\ColisType;
use App\Repository\ColisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/colis')]
class ColisController extends AbstractController
{
    #[Route('/', name: 'app_colis_index', methods: ['GET'])]
    public function index(ColisRepository $colisRepository): Response
    {
        return $this->render('colis/index.html.twig', [
            'colis' => $colisRepository->findAll(),
        ]);
    }


    // #[Route('/colis/{id}', name: 'app_colis_byuser', methods: ['GET'])]
    // public function getcolisbyuser(ColisRepository $colisRepository): Response
    // {
    //     return $this->render('colis/list.html.twig', [
    //         'colis' => $colisRepository->findAll(),
    //     ]);
    // }

    #[Route('/new', name: 'app_colis_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ColisRepository $colisRepository): Response
    {
        $coli = new Colis();
        $form = $this->createForm(ColisType::class, $coli);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $colisRepository->save($coli, true);

            return $this->redirectToRoute('app_colis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('colis/new.html.twig', [
            'coli' => $coli,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_colis_show', methods: ['GET'])]
    public function show(Colis $coli): Response
    {
        return $this->render('colis/show.html.twig', [
            'coli' => $coli,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_colis_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Colis $coli, ColisRepository $colisRepository): Response
    {
        $form = $this->createForm(ColisType::class, $coli);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $colisRepository->save($coli, true);

            return $this->redirectToRoute('app_colis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('colis/edit.html.twig', [
            'coli' => $coli,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_colis_delete', methods: ['POST'])]
    public function delete(Request $request, Colis $coli, ColisRepository $colisRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $coli->getId(), $request->request->get('_token'))) {
            $colisRepository->remove($coli, true);
        }

        return $this->redirectToRoute('app_colis_index', [], Response::HTTP_SEE_OTHER);
    }
}
