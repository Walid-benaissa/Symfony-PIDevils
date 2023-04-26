<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Repository\UtilisateurRepository;
use App\Repository\VoitureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

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
    public function index(UtilisateurRepository $ur): Response
    {
        $cond = $ur->findbyrole('Conducteur');
        $client = $ur->findbyrole('Client');

        return $this->render('1stpage.html.twig', [
            'controller_name' => 'ClassroomController',
            'cond' =>  $cond,
            'client' => $client
        ]);
    }

    #[Route('/', name: 'app_test1')]
    public function front(): Response
    {

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://api.adviceslip.com/advice',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2TLS,
        CURLOPT_CUSTOMREQUEST => 'GET',
    ]);

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);
    $advice="";
    if ($httpCode === 200) {
        $content = json_decode($response, true);
        $advice = $content['slip']['advice'];
    }
    return $this->render('herosection.html.twig', [
        'controller_name' => 'ClassroomController',
        'user' => $this->getUser(),
        'advice'=>$advice
    ]);
}

        
    

    #[Route('/admin/utilisateurstat', name: 'app_utilisateur_showStat', methods: ['GET'])]
    public function showStat(UtilisateurRepository $ur): Response
    {
        $cond = $ur->findbyrole('Conducteur');
        $client = $ur->findbyrole('Client');
        return $this->render('utilisateur/1stpage.html.twig', [
            'cond' =>  $cond,
            'client' => $client
        ]);
    }
}
