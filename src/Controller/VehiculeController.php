<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Entity\Utilisateur;
use App\Service\MailerService;
use App\Entity\PdfGeneratorService;
use App\Form\VehiculeType;
use App\Repository\VehiculeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/vehicule')]
class VehiculeController extends AbstractController
{
    #[Route('/statistique', name: 'stats')]
    public function stat(EntityManagerInterface $em,NotifierInterface $notifier,MailerService $mailer)
        {
    
            $vehicules= $em ->getRepository(Vehicule::class)
            ->findAll();
   


    

    $data = array();
    $total=0;
    foreach ($vehicules as $vehicule)  {
        $locations = $vehicule->getLocations();
        $num_locations = count($locations);
      
       
        $data[] = [$vehicule->getNomV(), $num_locations];
    }
    $mostReserved=null;
    foreach ($vehicules as $vehicule) 
{
    $locations = $vehicule->getLocations();
    $num_locations = count($locations);
    if (!$vehicule->isDiscountApplied() && $num_locations > 1 && (!$mostReserved || $vehicule->getPrix() > $mostReserved->getPrix())) 
    {
        $mostReserved = $vehicule;
        $users=$em->getRepository(Utilisateur::class)->findAll();
        foreach($users as $user)
    {
      $role=  $user->getRole();
      if($role =="Client")
    {
        $email=$user->getMail();
        $text="remise sur la vehicule ".$mostReserved->getNomV();
        $mailer->sendEmail($email,$text);
    }
    }
    }
}
if($mostReserved)
{
    $prix = $mostReserved->getPrix() * 0.8;// houni bch tssir remise 
    $mostReserved->setPrix($prix);
    $mostReserved->setDiscountApplied(True);
    $em->flush();

}
    //dd($total);
    $pr1 = 0;
    $pr2 = 0;


    foreach ($vehicules as $vehicule) {
        if ($vehicule->getPrix() >= 50)  :

            $pr1 += 1;
        else:

            $pr2 += 1;

        endif;

    }



    $pieChart = new PieChart();
    $pieChart->getData()->setArrayToDataTable(
        array_merge([['Nom', 'Nombre de locations']], $data)
    );
    $pieChart->getOptions()->setTitle('Statistiques sur les locations');
    $pieChart->getOptions()->setHeight(1000);
    $pieChart->getOptions()->setWidth(1400);
    $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
    $pieChart->getOptions()->getTitleTextStyle()->setColor('green');
    $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
    $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
    $pieChart->getOptions()->getTitleTextStyle()->setFontSize(30);

    $pieChart1 = new PieChart();
    $pieChart1->getData()->setArrayToDataTable(
        [['Prix', 'Nom'],
            ['voiture prix location  inferieur 50dt ', $pr2],
            ['voiture prix location superieur ou egale 50dt', $pr1],
        ]
    );
    $pieChart1->getOptions()->setTitle('statistique a partir des prix');
    $pieChart1->getOptions()->setHeight(1000);
    $pieChart1->getOptions()->setWidth(1400);
    $pieChart1->getOptions()->getTitleTextStyle()->setBold(true);
    $pieChart1->getOptions()->getTitleTextStyle()->setColor('green');
    $pieChart1->getOptions()->getTitleTextStyle()->setItalic(true);
    $pieChart1->getOptions()->getTitleTextStyle()->setFontName('Arial');
    $pieChart1->getOptions()->getTitleTextStyle()->setFontSize(30);



    return $this->render('stats/stat.html.twig', array('piechart' => $pieChart,'piechart2'=>$pieChart1));
        }
    #[Route('/admin/vehicule/', name: 'app_vehicule_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager,Request $request): Response
    {
        $queryBuilder = $entityManager->createQueryBuilder()
        ->select('v')
        ->from(Vehicule::class, 'v');

  

    // Sorting
    $sort = $request->query->get('sort');
    if ($sort) {
        $queryBuilder->orderBy('v.' . $sort, 'ASC');
    }

    $vehicules= $queryBuilder->getQuery()->getResult();
    return $this->render('vehicule/index.html.twig', [
        'vehicules' => $vehicules,
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

            return $this->redirectToRoute('app_vehicule', [], Response::HTTP_SEE_OTHER);
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
    #[Route('/pdf/vehicule', name: 'generator_service')]
    public function pdfEvenement(EntityManagerInterface $em): Response
    { 
        $vehicule= $em ->getRepository(Vehicule::class)
        ->findAll();
       

   

        $html =$this->renderView('pdf/index.html.twig', ['vehicule' => $vehicule]);
        $pdfGeneratorService=new PdfGeneratorService();
        $pdf = $pdfGeneratorService->generatePdf($html);

        return new Response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="document.pdf"',
        ]);
       
    }
    #[Route('/{idVehicule}/v/v', name: 'app_vehicule_sh', methods: ['GET'])]
    public function showv(Vehicule $vehicule): Response
    {
        return $this->render('vehicule/vehicule.html.twig', [
            'vehicule' => $vehicule,
        ]);
    }

    #[Route('/recherche', name: 'app_vehicule_recherche', methods: ['GET', 'POST'])]
    public function recherche(Request $request, VehiculeRepository $vehiculeRepository ): Response
    {
        $vehicule = new Vehicule();
        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);

    

    
        

        return $this->renderForm('vehicule/recherche.html.twig', [
            'vehicule' => $vehicule,
        ]);
    }
   

 
}
