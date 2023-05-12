<?php

namespace App\Controller;

use App\Repository\ReclamationRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/json/reclamationJson/new', name: 'app_reclamation_newJson', methods: ['GET', 'POST'])]
    public function newrec(UtilisateurRepository $u, Request $req, EntityManagerInterface $em, NormalizerInterface $Normalizer): Response
    {
        $reclamation = new Reclamation();
        $reclamation->setMessage($req->get('message'));
        $reclamation->setEtat($req->get('etat'));
        $reclamation->setType($req->get('type'));
        $reclamation->setUser($u->find($req->get('user')));
        $em->persist($reclamation);
        $em->flush();
        $jsonContent = $Normalizer->normalize($reclamation, 'json', ['groups' => "reclamation"]);
        return new Response(json_encode($jsonContent));
    }

    #[Route('/json/reclamationJson/update/{id}', name: 'app_reclamation_updateJson', methods: ['GET', 'POST'])]
    public function update(Reclamation $r, Request $req, EntityManagerInterface $em, NormalizerInterface $Normalizer): Response
    {
        $r->setMessage($req->get('message'));
        $r->setEtat($req->get('etat'));
        $r->setType($req->get('type'));
        $em->flush();

        $jsonContent = $Normalizer->normalize($r, 'json', ['groups' => 'reclamation']);
        return new Response(json_encode($jsonContent));
    }

    #[Route('/json/reclamationJson/delete/{id}', name: 'app_reclamation_deleteJson', methods: ['GET', 'POST'])]
    public function delete(Reclamation $r, EntityManagerInterface $em, Request $req, NormalizerInterface $Normalizer): Response
    {
        $em->remove($r);
        $em->flush();
        $jsonContent = $Normalizer->normalize($r, 'json', ['groups' => 'reclamation']);
        return new Response("Reclamation supprimé avec succéss " . json_encode($jsonContent));
    }

    #[Route("/json/reclamationJson", name: "app_reclamationJson_showByUser",methods: ['GET','POST'])]
    public function reclamationId(Request $req, NormalizerInterface $normalizer, ReclamationRepository $repo)
    {
        $recs = $repo->findByUser($req->get("id"));
        $json = $normalizer->normalize($recs,'json',['groups'=>"reclamation"]);
        return new Response(json_encode($json));
    }
    #[Route('/json/reclamationrec', name: 'apppjsonaffichage', methods: ['GET','POST'])]
    public function getRecla(ReclamationRepository $ok, NormalizerInterface $normalizer): Response
    {
        $Reclamation = $ok->findAll();
        $jsonContent = $normalizer->normalize($Reclamation, 'json', ['groups' => 'reclamation']);
        return new Response(json_encode($jsonContent));
    }


}