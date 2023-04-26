<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Form\VehiculeType;
use App\Repository\VehiculeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/vehicule')]
class VehiculeController extends AbstractController
{
    #[Route('/admin/vehicule/', name: 'app_vehicule_index', methods: ['GET'])]
    public function index(VehiculeRepository $vehiculeRepository): Response
    {
        return $this->render('vehicule/index.html.twig', [
            'vehicules' => $vehiculeRepository->findAll(),
        ]);
    }
    #[Route('/list', name: 'app_vehicule', methods: ['GET'])]
    public function listvehicule(Request $request , VehiculeRepository $vehiculeRepository,PaginatorInterface $paginator): Response
    {
        $allBesoinsQuery = $vehiculeRepository->createQueryBuilder('p')
        ->orderBy('p.nomV', 'ASC')
        ->getQuery();

    // Paginate the results of the query
    $pagination = $paginator->paginate(
        // Doctrine Query, not results
        $allBesoinsQuery,
        // Define the page parameter
        $request->query->getInt('page', 1),
        // Items per page
        4
    );
        return $this->render('vehicule/listvehicule.html.twig', [
            'vehicules' => $pagination,
        ]);
    }
//...................................................
    #[Route('/new', name: 'app_vehicule_new', methods: ['GET', 'POST'])]
    public function new(Request $request, VehiculeRepository $vehiculeRepository ,SluggerInterface $slugger = null): Response
    {
        $vehicule = new Vehicule();
        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photoC = $form->get('image')->getData();
            if ($photoC) {
                $originalImgName = pathinfo($photoC->getClientOriginalName(), PATHINFO_FILENAME);
                $newImgename = $originalImgName . '-' . uniqid() . '.' . $photoC->guessExtension();
    
                if ($slugger) {
                    $safeImgname = $slugger->slug($originalImgName);
                    $newImgename = $safeImgname . '-' . uniqid() . '.' . $photoC->guessExtension();
                }
    
                try {
                    $photoC->move(
                        $this->getParameter('imgb_directory'),
                        $newImgename
                    );
                } catch (FileException $e) {
                    // handle exception if something happens during file upload
                }
    
                $vehicule->setImage($newImgename);
            }
            $vehiculeRepository->save($vehicule, true);

            return $this->redirectToRoute('app_vehicule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vehicule/new.html.twig', [
            'vehicule' => $vehicule,
            'form' => $form,
        ]);
    }

    #[Route('/{idVehicule}', name: 'app_vehicule_show', methods: ['GET'])]
    public function show(Vehicule $vehicule): Response
    {
        return $this->render('vehicule/show.html.twig', [
            'vehicule' => $vehicule,
        ]);
    }

    #[Route('/{idVehicule}/edit', name: 'app_vehicule_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vehicule $vehicule, VehiculeRepository $vehiculeRepository): Response
    {
        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehiculeRepository->save($vehicule, true);

            return $this->redirectToRoute('app_vehicule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vehicule/edit.html.twig', [
            'vehicule' => $vehicule,
            'form' => $form,
        ]);
    }

    #[Route('/{idVehicule}', name: 'app_vehicule_delete', methods: ['POST'])]
    public function delete(Request $request, Vehicule $vehicule, VehiculeRepository $vehiculeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vehicule->getIdVehicule(), $request->request->get('_token'))) {
            $vehiculeRepository->remove($vehicule, true);
        }

        return $this->redirectToRoute('app_vehicule_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/dons/stat', name: 'app_don_stat')]
    public function displayDonStats(VehiculeRepository $donRepository): Response
    {
        $stats = $donRepository->countPeopleByTypeDon();

        return $this->render('vehicule/statistiquev.html.twig', [
            'stats' => $stats,
        ]);
    }
}
