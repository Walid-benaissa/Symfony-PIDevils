<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Repository\UtilisateurRepository;
use App\Repository\VoitureRepository;
use App\Service\ContextService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;


class VoitureControllerJson extends AbstractController
{

    #[Route('/json/voituserM/new', name: 'app_voiture_newJson', methods: ['GET', 'POST'])]
    public function new(UtilisateurRepository $u, Request $req, EntityManagerInterface $em, NormalizerInterface $Normalizer): Response
    {
        $v = new Voiture();
        $v->setImmatriculation($req->get('immatriculation'));
        $v->setEtat($req->get('etat'));
        $v->setMarque($req->get('marque'));
        $v->setModele($req->get('modele'));
        $v->setPhoto($req->get('photo'));
        $v->setUser($u->find($req->get('user')));
        $em->persist($v);
        $em->flush();

        $jsonContent = $Normalizer->normalize($v, 'json', ['groups' => 'voiture']);
        return new Response(json_encode($jsonContent));
    }

    #[Route('/json/modifiervoiture', name: 'app_voiture_updateJsonoui', methods: ['GET', 'POST'])]
    public function update(Request $req, EntityManagerInterface $em, NormalizerInterface $Normalizer, VoitureRepository $vr): Response
    {
        $id=$req->get('id');
        $v = $vr->findByUser($id);
        $v->setImmatriculation($req->get("immatriculation"));
        $v->setEtat($req->get('etat'));
        $v->setMarque($req->get('marque'));
        $v->setModele($req->get('modele'));
        $em->flush();
        $jsonContent = $Normalizer->normalize($v, 'json', ['groups' => 'voiture']);
        return new Response(json_encode($jsonContent));
    }

    #[Route('/json/voiture/voituserM', name: 'voitureJson')]
    public function showfrMobile(Request $req, NormalizerInterface $normalize, VoitureRepository $repo)
    {
        $id=$req->get("id");
        $recs = $repo->findByUser($id);
        $json = $normalize->normalize($recs, 'json', ['groups' => "voiture"]);
        return new Response(json_encode($json));
    }

    #[Route('/json/voiture/voituserM/delete/{id}', name: 'app_voiture_updateJson', methods: ['GET', 'POST'])]
    public function delete(Voiture $r, EntityManagerInterface $em, Request $req, NormalizerInterface $Normalizer): Response
    {
        $em->remove($r);
        $em->flush();
        $jsonContent = $Normalizer->normalize($r, 'json', ['groups' => 'voiture']);
        return new Response("voiture deleted successfully " . json_encode($jsonContent));
    }
}
