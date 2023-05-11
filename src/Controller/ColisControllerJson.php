<?php

namespace App\Controller;

use App\Entity\Colis;
use App\Entity\Livraison;
use App\Form\ColisType;
use App\Repository\ColisRepository;
use App\Repository\LivraisonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ColisControllerJson extends AbstractController
{


    #[Route('/colisjson/{id}', name: 'colisJsontest')]
    public function showcolisMobile(SerializerInterface $serialize, ColisRepository $repo,  $id)
    {
        $recs = $repo->findByUser($id);
        $json = $serialize->serialize($recs, 'json', ['groups' => "colis"]);
        return new Response(json_encode($json));
    }



    #[Route("/newColis", name: "app_colis_new_json", methods: ['GET', 'POST'])]
    public function newColis(Request $req, NormalizerInterface $normalizer, EntityManagerInterface $em): Response
    {
        $colis = new Colis();
        $colis->setNbItems($req->get('nbItems'));
        $colis->setDescription($req->get('description'));
        $colis->setPoids($req->get('poids'));
        $colis->setIdClient($this->getUser());
        $em->persist($colis);
        $em->flush();

        $jsonContent = $normalizer->normalize($colis, 'json', ['groups' => 'colis']);
        return new Response(json_encode($jsonContent));
    }

    // #[Route('/updateColisJSON/{id}', name: 'updateColisJSON', methods: ['GET', 'POST'])]
    // public function updateColisJSON($id, Request $req, EntityManagerInterface $em, NormalizerInterface $Normalizer): Response
    // {
    //     $colis = $em->getRepository(Colis::class)->find($id);
    //     if (!$colis) {
    //         return new Response('Colis not found', Response::HTTP_NOT_FOUND);
    //     }
    //     $colis->setAdresseDestinataire($req->get('adresseDestinataire'));
    //     $colis->setAdresseExpedition($req->get('adresseExpedition'));
    //     $colis->setPrix($req->get('prix'));
    //     $em->flush();

    //     $jsonContent = $Normalizer->normalize($livraison, 'json', ['groups' => 'livraison']);
    //     return new Response("livraison updated successfully " . json_encode($jsonContent));
    // }

    // #[Route('/livraisonJson/delete/{idLivraison}', name: 'app_livraison_deleteJson', methods: ['GET', 'POST'])]
    // public function delete($idLivraison, EntityManagerInterface $em, Request $req, NormalizerInterface $Normalizer): Response
    // {
    //     $livraison = $em->getRepository(Livraison::class)->find($idLivraison);

    //     if (!$livraison) {
    //         return new Response('Livraison not found', Response::HTTP_NOT_FOUND);
    //     }

    //     $em->remove($livraison);
    //     $em->flush();

    //     $jsonContent = $Normalizer->normalize($livraison, 'json', ['groups' => 'livraison']);
    //     return new Response("Livraison deleted successfully " . json_encode($jsonContent));
    // }
}
