<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CommentaireControllerJSON extends AbstractController
{
    #[Route('/json/commentaireJson/new', name: 'app_commentaire_newJson', methods: ['GET', 'POST'])]
    public function newcomm(UtilisateurRepository $u, Request $req, EntityManagerInterface $em, NormalizerInterface $Normalizer): Response
    {
        $commentaire = new Commentaire();
        $commentaire->setMessage($req->get('message'));
        $commentaire->setId1($u->find($req->get('user1')));
        $commentaire->setId2($u->find($req->get('user2')));
        $em->persist($commentaire);
        $em->flush();
        $jsonContent = $Normalizer->normalize($commentaire, 'json', ['groups' => "commentaire"]);
        return new Response(json_encode($jsonContent));
    }

    #[Route('/commentaireJson/{id}', name: 'app_evaluation_showJson', methods: ['GET', 'POST'])]
    public function showAvis($id, CommentaireRepository $cr, UtilisateurRepository $ur, Request $req, EntityManagerInterface $em, NormalizerInterface $Normalizer): Response
    {
        $u = $ur->find($id);
        $comms = $cr->findByUser($id);
        $jsonContent1 = ["evaluation" => $u->getEvaluation()];
        $jsonContent2 = $Normalizer->normalize($comms, 'json', ['groups' => "commentaire"]);
        $res = [$jsonContent1, "messages" => $jsonContent2];
        return new Response(json_encode($res));
    }

    #[Route('/commentaireJson/delete/{id}', name: 'app_commentaire_deleteJson', methods: ['GET', 'POST'])]
    public function delete(Commentaire $c, EntityManagerInterface $em, Request $req, NormalizerInterface $Normalizer): Response
    {
        $em->remove($c);
        $em->flush();
        $jsonContent = $Normalizer->normalize($c, 'json', ['groups' => 'commentaire']);
        return new Response("Commentaire supprimé " . json_encode($jsonContent));
    }
}
