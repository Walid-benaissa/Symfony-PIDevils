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
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;




class UtilisateurControllerJson extends AbstractController
{
    #[Route("/user/{id}", name: "reclamationJson")]
    public function showuserId(NormalizerInterface $normalizer, Utilisateur $utilisateur)
    {
        $userNormalises = $normalizer->normalize($utilisateur, 'json', ['groups' => "user"]);
        return new Response(json_encode($userNormalises));
    }



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
}
