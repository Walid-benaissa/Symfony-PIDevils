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

    #[Route('/updateVehiculeJSON/{idVehicule}', name: 'updateBesoinJSON', methods: ['GET', 'POST'])]
    public function updateStudentJSON($idVehicule, Request $req, EntityManagerInterface $em, NormalizerInterface $Normalizer): Response
    {
        $vehicule = $em->getRepository(Vehicule::class)->find($idVehicule);
        if (!$vehicule) {
            return new Response('Vehicule not found', Response::HTTP_NOT_FOUND);
        }
        $vehicule->setNomV($req->get('nom_v'));
        $vehicule->setId($req->get('id'));
        $vehicule->setImage($req->get('image'));
        $vehicule->setVille($req->get('ville'));
        $vehicule->setPrix($req->get('prix'));
        $vehicule->setDescription($req->get('description'));
        $vehicule->setType($req->get('type'));
        $em->flush();

        $jsonContent = $Normalizer->normalize($vehicule, 'json', ['groups' => 'Vehicule']);
        return new Response("Vehicle updated successfully " . json_encode($jsonContent));
    }
 

    #[Route('/vehiculeJson/delete/{idVehicule}', name: 'app_vehicule_updateJson', methods: ['GET', 'POST'])]
    public function delete($idVehicule, EntityManagerInterface $em, Request $req, NormalizerInterface $Normalizer): Response
    {
        $vehicule = $em->getRepository(Vehicule::class)->find($idVehicule);
    
        if (!$vehicule) {
            return new Response('Vehicule not found', Response::HTTP_NOT_FOUND);
        }
    
        $em->remove($vehicule);
        $em->flush();
    
        $jsonContent = $Normalizer->normalize($vehicule, 'json', ['groups' => 'Vehicule']);
        return new Response("Vehicle deleted successfully " . json_encode($jsonContent));
    }
    
    
}
  
