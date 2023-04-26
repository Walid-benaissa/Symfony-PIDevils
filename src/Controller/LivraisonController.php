<?php

namespace App\Controller;

use App\Entity\Livraison;
use App\Form\LivraisonType;
use App\Form\SmsType;
use App\Repository\LivraisonRepository;
use App\Repository\UtilisateurRepository;
use App\Service\TwilioClient;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twilio\Rest\Client;

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

    #[Route('/livraison/liste', name: 'app_livraisons_front', methods: ['GET'])]
    public function afficher(LivraisonRepository $livraisonRepository): Response
    {

        $livraisons = $livraisonRepository->findAll();

        return $this->render('livraison/list_all.html.twig', [
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



    #[Route('/livraison/delete/{id}', name: 'app_livraison_delete')]
    public function delete(Request $request,  Livraison $livraison = null, ManagerRegistry $doctrine): RedirectResponse

    {

        $manager = $doctrine->getManager();
        $manager->remove($livraison);
        $manager->flush();

        return $this->redirectToRoute('app_livraison_byuser', ['id' => $livraison->getIdClient()->getId()], Response::HTTP_SEE_OTHER);
    }

    // #[Route('/livraison/{id}/alls/prix/{prixMin}/{prixMax}', name: 'app_livraison_prix')]
    // public function LivraisonByprix(ManagerRegistry $doctrine, $prixMin, $prixMax, LivraisonRepository $livraisonRepository): Response
    // {

    //     return $this->render('livraison/list.html.twig', [
    //         'livraisons' => $livraisonRepository->findLivraisonByPrixInterval($prixMin, $prixMax),
    //     ]);
    // }


    #[Route('/rechercheParPrix', name: 'app_livraison_prix')]
    public function RechercherPrix(Request $request, LivraisonRepository $livraisonRepository): Response
    {
        $minPrix = $request->get('min');
        $maxPrix = $request->get('max');

        return $this->render('livraison/list_all.html.twig', [
            'livraisons' => $livraisonRepository->findByPrix($minPrix, $maxPrix),



        ]);
    }
    // #[Route('/sendsms', name: 'Password_send_sms', methods: ['GET'])]
    // // Send SMS notification to admin
    // public function sendSms(Request $request, TwilioClient $twilioClient, EntityManagerInterface $entityManager): Response
    // {   
    //     $form = $this->createForm(SmsType::class);

    //     $form->handleRequest($request);
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $accountSid = 'AC23c10455ba1e24c96fb6bcc98f9183a0';
    //         $authToken = 'ca73d2dd53ebcc0b60d9cb40b2d47931';
    //         $client = new Client($accountSid, $authToken);
    //         $message = $client->messages->create(
    //             '+21628440373', // replace with admin's phone number
    //             [
    //                 'from' => '+16076955652', // replace with your Twilio phone number
    //                 'body' => 'Bonjour cher client, votre livraison est en route. Merci pour votre confiance !', // replace with your message
    //             ]
    //         );
    //     }

    //     return $this->redirectToRoute('app_livraisons_front');
    // }


    // #[Route('/sendsms', name: 'Password_send_sms', methods: ['GET'])]
    // public function sendSms(Request $request, TwilioClient $twilioClient, EntityManagerInterface $entityManager): Response
    // {
    //     $LivraisonController = new LivraisonController();
    //     $form = $this->createForm(SmsType::class);

    //     $form->handleRequest($request);

    //     $to = '+216' . "28440373"; // The phone number to send the SMS to
    //     $from = '+16076955652'; // Your Twilio phone number
    //     $body = 'Bonjour cher client, votre livraison est en route. Merci pour votre confiance !.'; // The message body

    //     // $twilioClient->sendSMS($to, $from, $body);
    //     // $this->new($request, $entityManager);

    //     return $this->redirectToRoute('sms/index.html.twig');
    // }
}
