<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\CourseType;
use App\Repository\CourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Utilisateur;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;




class CourseController_Json extends AbstractController
{
    #[Route('/json/showfr_get', name: 'app_course_showfr_json', methods: ['GET', 'POST'])]
    public function getCourse(CourseRepository $ok, NormalizerInterface $normalizer): Response
    {
        $Course = $ok->findAll();
        $jsonContent = $normalizer->normalize($Course, 'json', ['groups' => 'Course']);
        return new Response(json_encode($jsonContent));
    }
    
    #[Route('/json/new_courseApijson', name: 'app_course_new_json', methods: ['GET', 'POST'])]   
    function new_api(Request $req, EntityManagerInterface $entityManager, ManagerRegistry $doctrine)
    {
       
       
        $course = new Course();
        $course->setPointDepart($req->get('pointDepart'));
        $course->setPointDestination($req->get('pointDestination'));
        $course->setDistance($req->get('distance'));
        $course->setPrix($req->get('prix'));
        $course->setStatutCourse($req->get('statutCourse'));
       
        
        $entityManager->persist($course);
        $entityManager->flush();
    
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($course);
    
        return new JsonResponse($formatted);
    }
    
    #[Route('/json/edit_courseApijson/{idCourse}', name: 'app_course_edit_json', methods: ['GET', 'POST'])]
    public function edit_api($idCourse, Request $req, EntityManagerInterface $em): Response
    {
        $course = $em->getRepository(Course::class)->find($idCourse);
        if (!$course) {
            return new Response('Course Introuvable', Response::HTTP_NOT_FOUND);
        }
    
        $course->setPointDepart($req->get('pointDepart'));
        $course->setPointDestination($req->get('pointDestination'));
        $course->setDistance($req->get('distance'));
        $course->setPrix($req->get('prix'));
        $course->setStatutCourse($req->get('statutCourse'));
        $em->flush();
    
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($course);
    
        return new JsonResponse(["" => "Course mise à jour avec succès", "course" => $formatted]);
    }

    #[Route('/json/delete_courseApijson/{idCourse}', name: 'app_course_delete_json', methods: ['GET', 'POST'])]
    public function delete_api($idCourse, EntityManagerInterface $em, Request $req): Response
    {
        $course = $em->getRepository(Course::class)->find($idCourse);
    
        if (!$course) {
            return new Response('Course Introuvable', Response::HTTP_NOT_FOUND);
        }
    
        $em->remove($course);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($course);
    
        return new JsonResponse(["" => "Course supprimée avec succès", "course" => $formatted]);
    }
    
    
   
}
