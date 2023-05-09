<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use App\Entity\Conducteur;
use App\Entity\Utilisateur;
use App\Entity\Voiture;
use App\Form\ConducteurType;
use App\Form\CreerCompteType;
use App\Form\ModifProfilType;
use App\Form\UtilisateurType;
use App\Repository\ConducteurRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Profiler\Profiler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\FormLoginAuthenticator;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;




class UtilisateurControllerJson extends AbstractController
{
    #[Route("/user/{id}", name: "userJson")]
    public function showuserId(NormalizerInterface $normalizer, Utilisateur $utilisateur)
    {
        $userNormalises = $normalizer->normalize($utilisateur, 'json', ['groups' => "user"]);
        return new Response(json_encode($userNormalises));
    }

    /* #[Route("/user/login/{id}", name: "userJson")]
    public function authentif(Request $req, NormalizerInterface $normalizer, Utilisateur $u, UserCheckerInterface $checker, UserAuthenticatorInterface $userAuthenticator, FormLoginAuthenticator $formLoginAuthenticator)
    {
        $checker->checkPreAuth($u);
        $res=$userAuthenticator->authenticateUser($u, $formLoginAuthenticator, $req);
        $userNormalises = $normalizer->normalize($u, 'json', ['groups' => "user"]);
        return new Response(json_encode($res));
    } */

    #[Route("/creatCptMobile", name: "app_utilisateur_newM", methods: ['GET', 'POST'])]
    public function newcompteM(Request $req, NormalizerInterface $normalizer, EntityManagerInterface $em): Response
    {
        $user = new Utilisateur();
        $user->setNom($req->get('nom'));
        $user->setPrenom($req->get('prenom'));
        $user->setMail($req->get('mail'));
        $user->setMdp($req->get('mdp'));
        $user->setNumTel($req->get('num_tel'));
        $user->setRole($req->get('role'));
        $em->persist($user);
        $em->flush();

        $jsonContent = $normalizer->normalize($user, 'json', ['groups' => 'user']);
        return new Response(json_encode($jsonContent));
    }
    #[Route("/creatCptMobilec", name: "app_utilisateur_newcM", methods: ['GET', 'POST'])]
    public function newcompteCM(UtilisateurRepository $ur, Request $req, NormalizerInterface $normalizer, EntityManagerInterface $em): Response
    {
        $user = new Utilisateur();
        $c = new Conducteur();
        $user->setNom($req->get('nom'));
        $user->setPrenom($req->get('prenom'));
        $user->setMail($req->get('mail'));
        $user->setMdp($req->get('mdp'));
        $user->setNumTel($req->get('num_tel'));
        $user->setRole($req->get('role'));
        $c->setB3($req->get('b3'));
        $c->setPermis($req->get('permis'));
        $em->persist($user);
        $em->flush();
        $c->setUtilisateur($ur->findbymail($user->getMail()));
        $em->persist($c);
        $em->flush();

        $jsonContent = $normalizer->normalize($user, 'json', ['groups' => 'user']);
        return new Response(json_encode($jsonContent));
    }


    #[Route('/updateuser/{id}', name: 'app_utilisateur_editM', methods: ['GET', 'POST'])]
    public function edituserId($id, Request $req, EntityManagerInterface $em, NormalizerInterface $Normalizer): Response
    {
        $u = $em->getRepository(Utilisateur::class)->find($id);
        if (!$u) {
            return new Response('Utilisateur not found', Response::HTTP_NOT_FOUND);
        }
        $u->setNom($req->get('nom'));
        $u->setPrenom($req->get('prenom'));
        $u->setMail($req->get('mail'));
        $u->setNumTel($req->get('num_tel'));
        $em->flush();

        $jsonContent = $Normalizer->normalize($u, 'json', ['groups' => 'user']);
        return new Response("Utilisateur updated successfully " . json_encode($jsonContent));
    }
}
