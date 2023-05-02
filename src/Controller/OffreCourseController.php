<?php

namespace App\Controller;

use App\Entity\OffreCourse;
use App\Form\OffreCourseType;
use App\Repository\OffreCourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Knp\Component\Pager\PaginatorInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[Route('/offre/course')]
class OffreCourseController extends AbstractController
{
    #[Route('/', name: 'app_offre_course_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager,Request $request): Response
    {
        $queryBuilder = $entityManager->createQueryBuilder()
        ->select('o')
        ->from(OffreCourse::class, 'o');
         // Sorting
    $sort = $request->query->get('sort');
    if ($sort) {
        $queryBuilder->orderBy('o.' . $sort, 'ASC');
    }
    $offreCourses= $queryBuilder->getQuery()->getResult();

        return $this->render('offre_course/index.html.twig', [
            'offre_courses' => $offreCourses,
        ]);
    }
    
    #[Route('/statistique', name: 'app_stats')]
    public function stat(EntityManagerInterface $em, ChartBuilderInterface $chartBuilder)
    {
        $offres_actives = $em->getRepository(OffreCourse::class)
            ->findBy(['statutOffre' => 'Actif']);
        $offres_inactives = $em->getRepository(OffreCourse::class)
            ->findBy(['statutOffre' => 'Inactif']);
            $data = [
                ['Actif', count($offres_actives)],
                ['Inactif', count($offres_inactives)]
            ];
    
    //     $pieChart = new PieChart();
    // $pieChart->getData()->setArrayToDataTable($data);
    // $pieChart->getOptions()->setTitle('Statistiques sur les offres');
    // $pieChart->getOptions()->setHeight(400);
    // $pieChart->getOptions()->setWidth(600);
    // $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
    // $pieChart->getOptions()->getTitleTextStyle()->setColor('green');
    // $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
    // $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
    // $pieChart->getOptions()->getTitleTextStyle()->setFontSize(30);

    $pieChart = $chartBuilder->createChart(Chart::TYPE_LINE);

        $pieChart->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [0, 10, 5, 2, 20, 30, 45],
                ],
            ],
        ]);

        $pieChart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
        ]);
   



    return $this->render('offre_course/stats_by_option_offre.html.twig', [
    'piechart' => $pieChart,
    'data' => $data
]);

    }
    
    #[Route('/new', name: 'app_offre_course_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OffreCourseRepository $offreCourseRepository, NotifierInterface $notifier,SessionInterface $session): Response
    {
        $offreCourse = new offreCourse();
        $form = $this->createForm(offreCourseType::class, $offreCourse);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $offreCourseRepository->save($offreCourse, true);

            /*$session->getFlashBag()->add('success', 'Une nouvelle offre a été ajoutée avec succès !');*/
            return $this->redirectToRoute('app_offre_course_index');
        }
        
        return $this->renderForm('offre_course/new.html.twig', [
            'offre_course' => $offreCourse,
            'form' => $form
        ]);
        
    }

    #[Route('/{idOffre}', name: 'app_offre_course_show', methods: ['GET'])]
    public function show(OffreCourse $offreCourse,FlashyNotifier $flashy): Response
    {
        $flashy->info('Verifier les details !', 'http://your-awesome-link.com');
        return $this->render('offre_course/show.html.twig', [
            'offre_course' => $offreCourse,

        ]);
    }

    #[Route('/{idOffre}/edit', name: 'app_offre_course_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, OffreCourse $offreCourse, OffreCourseRepository $offreCourseRepository): Response
    {
        $form = $this->createForm(OffreCourseType::class, $offreCourse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offreCourseRepository->save($offreCourse, true);

            return $this->redirectToRoute('app_offre_course_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('offre_course/edit.html.twig', [
            'offre_course' => $offreCourse,
            'form' => $form,
        ]);
    }

    #[Route('/{idOffre}', name: 'app_offre_course_delete', methods: ['POST'])]
    public function delete(Request $request, OffreCourse $offreCourse, OffreCourseRepository $offreCourseRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$offreCourse->getIdOffre(), $request->request->get('_token'))) {
            $offreCourseRepository->remove($offreCourse, true);
        }

        return $this->redirectToRoute('app_offre_course_index', [], Response::HTTP_SEE_OTHER);
    }

   /* #[Route('/statistique', name: 'stats')]
    public function stat()
        {
    
            $repository = $this->getDoctrine()->getRepository(OffreCourse::class);
    $OffreCourses = $repository->findAll();
    $em = $this->getDoctrine()->getManager();
    $data = array();
    $total=0;
    $mostReserved = null;
    foreach ($OffreCourses as $OffreCourse) {
        $statutOffre = $OffreCourse->getStatutOffre();
        $Offre = count($statutOffre);
       
       
        $data[] = [$OffreCourse->getStatutOffre(), $Offre];
    }
    $pieChart = new PieChart();
    $pieChart->getData()->setArrayToDataTable(
        array_merge([['Titre', 'Nombre de réservations']], $data)
    );
    $pieChart->getOptions()->setTitle('Statistiques sur les réservations');
    $pieChart->getOptions()->setHeight(1000);
    $pieChart->getOptions()->setWidth(1400);
    $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
    $pieChart->getOptions()->getTitleTextStyle()->setColor('green');
    $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
    $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
    $pieChart->getOptions()->getTitleTextStyle()->setFontSize(30);
    return $this->render('stats/stat.html.twig', array('piechart' => $pieChart));
}*/
#[Route('/dons/stat', name: 'app_don_stat')]
    public function displayDonStats(OffreCourseRepository $donRepository): Response
    {
        $stats = $donRepository->countPeopleByTypeDon();

        return $this->render('offre_course/statistique.html.twig', [
            'stats' => $stats,
        ]);
    }
#[Route('/statistique', name: 'stats')] 
public function statsByOptionOffre(EntityManagerInterface $em)
{
    $query = $em->createQueryBuilder()
                ->select('o.optionsOffre, count(o.optionsOffre) as nb_offres')
                ->from('App\Entity\OffreCourse', 'o')
                ->groupBy('o.optionsOffre')
                ->getQuery();

    $data = $query->getResult();

    return $this->render('course/stats_by_option_offre.html.twig', [
        'data' => $data
    ]);
}


}
