<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Repository\VoitureRepository;
use App\Service\ContextService;
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
    #[Route('/voiture/voituserM/{id}', name: 'voitureJsonsss')]
    public function showfrMobile(NormalizerInterface $normalize, VoitureRepository $repo,  $id)
    {
        $recs = $repo->findByUser($id);
        $json = $normalize->normalize($recs, 'json', ['groups' => "voiture"]);
        return new Response(json_encode($json));
    }
}
