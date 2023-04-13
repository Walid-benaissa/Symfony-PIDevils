<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Repository\VoitureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

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
