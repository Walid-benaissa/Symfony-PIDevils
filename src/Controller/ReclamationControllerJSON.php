<?php

namespace App\Controller;

use App\Repository\ReclamationRepository;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Entity\Reclamation;
use App\Form\ReclamationType;
use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;



class ReclamationControllerJSON extends AbstractController
{

    #[Route('/admin/reclamation', name: 'app_reclamation_index')]
    public function index(TranslatorInterface $translator,ReclamationRepository $reclamationRepository): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),
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

    

    #[Route('/admin/reclamation/{id}/edit', name: 'app_reclamation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        $form = $this->createFormBuilder()
        ->add('etat', ChoiceType::class, ['choices'  => [
            'Ouvert' => 'Ouvert',
            'En Cours' => "En Cours",
            'Traité' => 'Traite',
        ],])
        ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $reclamation->setEtat($form->getData()['etat']);
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

    #[Route("/reclamationJson/{id}", name: "reclamationJson")]
    public function reclamationId($id, SerializerInterface $serializer, ReclamationRepository $repo)
    {
        $recs = $repo->findByUser($id);
        $json = $serializer->serialize($recs,'json',['groups'=>"reclamation"]);
        return new Response($json);
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

    
}