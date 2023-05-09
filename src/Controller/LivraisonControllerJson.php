<?php

namespace App\Controller;


use App\Entity\Livraison;
use App\Entity\Utilisateur;
use App\Form\LivraisonType;
use App\Form\SmsType;
use App\Repository\LivraisonRepository;
use App\Repository\UtilisateurRepository;
use App\Service\TwilioClient;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twilio\Rest\Client;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


class LivraisonControllerJson extends AbstractController
{


    #[Route('/show_getLivraison', name: 'app_livraison_showfr_json', methods: ['GET'])]
    public function show_api(LivraisonRepository $LivraisonRepository): Response
    {
        $livraisons = $LivraisonRepository->findByOffre();
        $data = [];
        foreach ($livraisons as $lvs) {
            $data[] = [

                'idLivraison' => $lvs->getidLivraison(),
                'adresseExpedition' => $lvs->getadresseExpedition(),
                'adresseDestinataire' => $lvs->getAdresseDestinataire(),
                'etat' => $lvs->getEtat(),
                'prix' => $lvs->getPrix(),

            ];
        }
        return $this->json($data, 200, ['Content-Type' => 'application/json']);
    }



    #[Route("/newLivraison", name: "app_livraison_new_json", methods: ['GET', 'POST'])]
    public function newLivraison(Request $req, NormalizerInterface $normalizer, EntityManagerInterface $em): Response
    {
        $livraison = new Livraison();
        $livraison->setAdresseExpedition($req->get('adresseExpedition'));
        $livraison->setAdresseDestinataire($req->get('adresseDestinataire'));
        $livraison->setEtat("En attente");
        $livraison->setPrix($req->get('prix'));
        $livraison->setIdClient($this->getUser());
        $em->persist($livraison);
        $em->flush();

        $jsonContent = $normalizer->normalize($livraison, 'json', ['groups' => 'user']);
        return new Response(json_encode($jsonContent));
    }

    #[Route('/updateLivraisonJSON/{idLivraison}', name: 'updateLivraisonJSON', methods: ['GET', 'POST'])]
    public function updateLivraisonJSON($idLivraison, Request $req, EntityManagerInterface $em, NormalizerInterface $Normalizer): Response
    {
        $livraison = $em->getRepository(Livraison::class)->find($idLivraison);
        if (!$livraison) {
            return new Response('Livraison not found', Response::HTTP_NOT_FOUND);
        }
        $livraison->setAdresseDestinataire($req->get('adresseDestinataire'));
        $livraison->setAdresseExpedition($req->get('adresseExpedition'));
        $livraison->setPrix($req->get('prix'));
        $em->flush();

        $jsonContent = $Normalizer->normalize($livraison, 'json', ['groups' => 'Livraison']);
        return new Response("livraison updated successfully " . json_encode($jsonContent));
    }

    #[Route('/livraisonJson/delete/{idLivraison}', name: 'app_livraison_deleteJson', methods: ['GET', 'POST'])]
    public function delete($idLivraison, EntityManagerInterface $em, Request $req, NormalizerInterface $Normalizer): Response
    {
        $livraison = $em->getRepository(Livraison::class)->find($idLivraison);

        if (!$livraison) {
            return new Response('Livraison not found', Response::HTTP_NOT_FOUND);
        }

        $em->remove($livraison);
        $em->flush();

        $jsonContent = $Normalizer->normalize($livraison, 'json', ['groups' => 'Livraison']);
        return new Response("Livraison deleted successfully " . json_encode($jsonContent));
    }
}
