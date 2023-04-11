<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class TestController extends AbstractController
{
    #[Route('/back', name: 'app_test')]
    public function index(): Response
    {
        return $this->render('1stpage.html.twig', [
            'controller_name' => 'ClassroomController',
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
