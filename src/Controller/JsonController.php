<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

#[Route('/vehicule')]
class JsonController extends AbstractController
{
    #[Route('/allVehicule/json', name: 'appjsonaffichage', methods: ['GET'])]
    public function getVehiculeeee(VehiculeRepository $ok, NormalizerInterface $normalizer): Response
    {
        $Vehicule = $ok->findAll();
        $jsonContent = $normalizer->normalize($Vehicule, 'json', ['groups' => 'Vehicule']);
        return new Response(json_encode($jsonContent));
    }

    #[Route("/addvJSON/new", name: "addVJSON", methods: ['GET'])]
    public function addvJnnnnSON(Request $req, NormalizerInterface $normalizer, EntityManagerInterface $em): Response
    {
        $vehicule = new Vehicule();
        $vehicule->setNomV($req->get('nom_v'));
        $vehicule->setId($req->get('id'));
        $vehicule->setImage($req->get('image'));
        $vehicule->setVille($req->get('ville'));
        $vehicule->setPrix($req->get('prix'));
        $vehicule->setDescription($req->get('description'));
        $vehicule->setType($req->get('type'));

        $em->persist($vehicule);
        $em->flush();

        $jsonContent = $normalizer->normalize($vehicule, 'json', ['groups' => 'Vehicule']);
        return new Response(json_encode($jsonContent));
    }
    #[Route("updateBesoinJSON/{idVehicule}", name: "updateBesoinJSON")]
    public function updateStudentJSON(Request $req, $idVehicule, NormalizerInterface $Normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $vehicule = $em->getRepository(Vehicule::class)->find($idVehicule);
        $vehicule->setNomV($req->get('nom_v'));
        $vehicule->setId($req->get('id'));
        $vehicule->setImage($req->get('image'));
        $vehicule->setVille($req->get('ville'));
        $vehicule->setPrix($req->get('prix'));
        $vehicule->setDescription($req->get('description'));
        $vehicule->setType($req->get('type'));
     

        $em->flush();

        $jsonContent = $Normalizer->normalize($vehicule, 'json', ['groups' => 'Vehicule']);
        return new Response("vehicule updated successfully " . json_encode($jsonContent));
    }
}