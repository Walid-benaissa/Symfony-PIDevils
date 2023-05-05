<?php

namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class ReclamationController extends AbstractController
{

    #[Route('/admin/reclamation', name: 'app_reclamation_index')]
    public function index(TranslatorInterface $translator,ReclamationRepository $reclamationRepository): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),
        ]);
    }

    #[Route('/reclamation/new', name: 'app_reclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReclamationRepository $reclamationRepository): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);
        $reclamation->setEtat('Ouvert');
        if ($form->isSubmitted() && $form->isValid()) {
            $reclamation->setUser($this->getUser());
            $reclamationRepository->save($reclamation, true);
            return $this->redirectToRoute('app_reclamation_showuser', ['id' => $reclamation->getUser()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/admin/reclamation/{id}', name: 'app_reclamation_show', methods: ['GET'])]
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }
    #[Route('/admin/reclamation/print/{id}', name: 'app_reclamation_pdf_show')]
    public function showpdf(Reclamation $reclamation)
    {
        $html =  $this->renderView('reclamation\reclamationpdf.html.twig', ['reclamation' => $reclamation,]);
        $dompdf = new Dompdf(['chroot' => __DIR__, 'enable_remote' => true]);
        $dompdf->loadHtml($html);
        $dompdf->render();
        return new Response(
            $dompdf->stream('resume', ["Attachment" => false]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }

    #[Route('/reclamation/{id}', name: 'app_reclamation_showuser', methods: ['GET'])]
    public function showrecuser(ReclamationRepository $rp, $id): Response
    {
        return $this->render('reclamation/indexclient.html.twig', [
            'reclamations' => $rp->findByUser($id),
        ]);
    }

    #[Route('/admin/reclamation/{id}/edit', name: 'app_reclamation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->add('etat', ChoiceType::class, ['choices'  => [
            'Ouvert' => 'Ouvert',
            'En Cours' => "En Cours",
            'Traité' => 'Traite',
        ],]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationRepository->save($reclamation, true);

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/admin/reclamation/{id}', name: 'app_reclamation_delete', methods: ['POST'])]
    public function delete(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reclamation->getId(), $request->request->get('_token'))) {
            $reclamationRepository->remove($reclamation, true);
        }

        return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }
}
