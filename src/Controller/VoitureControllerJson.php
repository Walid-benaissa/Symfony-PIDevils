<?php

namespace App\Controller;

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


class VoitureControllerJson extends AbstractController
{
    #[Route('/voiture/voituserM/{id}', name: 'app_voiture_showfrM', methods: ['GET'])]
    public function showfrMobile(NormalizerInterface $normalizer, VoitureRepository $voitureRepository, $id): Response
    {
        $v = $voitureRepository->findByUser($id);
        $voitnorm = $normalizer->normalize($v, 'json', ['groups' => "voiture"]);
        return new Response(json_encode($voitnorm));
    }
}
