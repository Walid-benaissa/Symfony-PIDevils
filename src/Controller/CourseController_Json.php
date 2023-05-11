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




class CourseController_Json extends AbstractController
{
    #[Route('/json/showfrget', name: 'app_course_showfr_json', methods: ['GET', 'POST'])]
    public function showfr_api(CourseRepository $courseRepository): Response
    {
        $courses = $courseRepository->findAll() ;
        $data = [] ;
        foreach($courses as $crs) {
            $data [] = [
                   
            'idCourse'=> $crs->getIdCourse(),
            'pointDepart'=> $crs ->getPointDepart(),
            'pointDestination'=> $crs ->getPointDestination(),
            'distance'=> $crs ->getDistance(),
            'prix'=> $crs ->getPrix(),
            'statutCourse'=> $crs ->getStatutCourse(),
           
            ] ;
        }       
        return $this->json($data,200,['Content-Type'=>'application/json'] );
            
        
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
    
  
   
}
