<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Repository\VoitureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart; 

class TestController extends AbstractController
{
    #[Route('/redirect', name: 'app_test_role')]
    public function rolescheck(VoitureRepository $vr): Response
    {
        $voiture = new Voiture();
        $voiture->setuser($this->getUser());
        if ($vr->findByUser($voiture->getuser()->getId()))
            $hasVoiture = true;
        $user = $this->getUser();
        if (in_array('ROLE_ADMIN', $user->getRoles(), true)) {
            return $this->redirectToRoute('app_test', [], Response::HTTP_SEE_OTHER);
        }
        return $this->redirectToRoute('app_test1', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/admin', name: 'app_test')]
    public function index(ChartBuilderInterface $chartBuilder): Response
    {
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);

        $chart->setData([
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

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
        ]);
        return $this->render('1stpage.html.twig', [
            'controller_name' => 'ClassroomController',
            "chart"=>$chart
        ]);
    }

    #[Route('/', name: 'app_test1')]
    public function front(): Response
    {
        return $this->render('herosection.html.twig', [
            'controller_name' => 'ClassroomController',
            'user' => $this->getUser()
        ]);
    }
}
