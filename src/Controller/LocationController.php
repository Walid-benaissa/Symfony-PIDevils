<?php

namespace App\Controller;
use DateTime;
use App\Entity\Location;
use App\Entity\Vehicule;
use App\Form\LocationType;
use App\Repository\LocationRepository;

use App\Repository\VehiculeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;

#[Route('/location')]
class LocationController extends AbstractController
{
    #[Route('/', name: 'app_location_index', methods: ['GET'])]
    public function index(LocationRepository $locationRepository): Response
    {
        return $this->render('location/index.html.twig', [
            'locations' => $locationRepository->findAll(),
        ]);
    }

    #[Route('/list', name: 'app_location_list', methods: ['GET'])]
    public function list(LocationRepository $locationRepository): Response
    {
        return $this->render('location/Listlocation.html.twig', [
            'locations' => $locationRepository->findAll(),
        ]);
    }

    #[Route('/new/{idVehicule}', name: 'app_location_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LocationRepository $locationRepository,NotifierInterface $notifier,EntityManagerInterface $em,Vehicule $idVehicule): Response
    {
        $location = new Location();
        $location->setIdVehicule($idVehicule);
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $locationRepository->save($location, true);
            $date_debut=$location->getDateDebut();
            $date_fin=$location->getDateFin();
            $date_debut1 = DateTime::createFromFormat('Y-m-d', $date_debut->format('Y-m-d'));
            $date_fin1 = DateTime::createFromFormat('Y-m-d', $date_fin->format('Y-m-d'));
            $interval = $date_debut1->diff($date_fin1);
            $nb_jours = (int) $interval->format('%a');
           
            
            $idVehicule=$form->get('idVehicule')->getData();
            $vehicule=$em->getRepository(Vehicule::class)->findOneBy(['idVehicule'=>$idVehicule]);
            $prix=$vehicule->getPrix();
           
                $total=($prix  )*$nb_jours;
     
            
                $notifier->send(new Notification('La somme de votre réservation est de ' . $total . ' Dt', ['browser']));

            return $this->redirectToRoute('app_location_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('location/new.html.twig', [
            'location' => $location,
            'form' => $form,
        ]);
    }

    #[Route('/{idContrat}', name: 'app_location_show', methods: ['GET'])]
    public function show(Location $location): Response
    {
        return $this->render('location/show.html.twig', [
            'location' => $location,
        ]);
    }

    #[Route('/{idContrat}/edit', name: 'app_location_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Location $location, LocationRepository $locationRepository): Response
    {
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $locationRepository->save($location, true);

            return $this->redirectToRoute('app_location_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('location/edit.html.twig', [
            'location' => $location,
            'form' => $form,
        ]);
    }

    #[Route('/{idContrat}', name: 'app_location_delete', methods: ['POST'])]
    public function delete(Request $request, Location $location, LocationRepository $locationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$location->getIdContrat(), $request->request->get('_token'))) {
            $locationRepository->remove($location, true);
        }

        return $this->redirectToRoute('app_location_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/statique/stat', name: 'statique_app_name')]
    public function countAll(LocationRepository $locationRepo ,VehiculeRepository $vehiculeRepo): Response
    {
        $locationCount = $locationRepo->count_location();
        $vehiculeCount = $vehiculeRepo->count_vehicule();
    

        return $this->render('location/statistique.html.twig', [
            'locationCount' => $locationCount,
            'vehiculeCount' => $vehiculeCount,
        
        ]);
    }
    #[Route('/show_in_map/{idContrat}', name: 'app_location_map', methods: ['GET'])]
    public function Map( Location $idContrat,EntityManagerInterface $entityManager ): Response
    {

        $location = $entityManager
            ->getRepository(Location::class)->findBy( 
                ['idContrat'=>$idContrat ]
            );
        return $this->render('map/api_arcgis.html.twig', [
            'location' => $location,
        ]);
    }
    
}
