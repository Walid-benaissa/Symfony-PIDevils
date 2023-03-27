<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class TestController extends AbstractController
{
    #[Route('/', name: 'app_test')]
    public function index(): Response
    {
        return $this->render('1stpage.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }
    
    #[Route('/front', name: 'app_test1')]
    public function front(): Response
    {
        return $this->render('herosection.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }
}
