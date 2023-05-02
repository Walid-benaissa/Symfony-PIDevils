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
use Doctrine\Common\Persistence\ManagerRegistry;


#[Route('/course')]
class CourseController extends AbstractController
{
    #[Route('/', name: 'app_course_index', methods: ['GET'])]
    public function index(CourseRepository $courseRepository): Response
    {
        return $this->render('course/index.html.twig', [
            'courses' => $courseRepository->findAll(),
        ]);
    }
    #[Route('/showfr', name: 'app_course_showfr', methods: ['GET'])]
    public function showfr(CourseRepository $courseRepository): Response
    {
        return $this->render('course/showFront.html.twig', [
            'courses' => $courseRepository->findAll(),
        ]);
    }
   
    #[Route('/new', name: 'app_course_new', methods: ['GET', 'POST'])]
public function new(Request $request, CourseRepository $courseRepository): Response
{
    $course = new Course();
    $form = $this->createForm(CourseType::class, $course);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $courseRepository->save($course, true);

        // Intégration Stripe pour le paiement en ligne
        Stripe::setApiKey('sk_test_VePHdqKTYQjKNInc7u56JBrQ'); // à remplacer par votre propre clé secrète Stripe

        // Création d'une session de paiement Stripe
        $session = \Stripe\Checkout\Session::create([
          
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur', // Remplacez par la devise que vous souhaitez utiliser
                    'product_data' => [
                        'name' => 'Course ' . $course->getIdCourse(),
                        'description' => $course->getPointDepart() . ' -> ' . $course->getPointDestination() . ' (' . $course->getDistance() . ' km)',
                    ],
                    'unit_amount' => $course->getPrix() * 100, // conversion du prix en cents pour Stripe
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('app_course_showfr', [], 0),
            'cancel_url' => $this->generateUrl('app_course_new', [], 0),
        ]);

       
        // Redirection vers l'interface de paiement Stripe
        return $this->redirect($session->url);
    }

    return $this->renderForm('course/new.html.twig', [
        'course' => $course,
        'form' => $form,
    ]);
    
    return $this->redirectToRoute('app_course_showfr');
}

    #[Route('/{id}', name: 'app_course_showuser', methods: ['GET'])]
    public function showuser(CourseRepository $cp, $id): Response
    {
        return $this->render('course/list.html.twig', [
            'courses' => $cp->findByUser($id),
        ]);
    }
    #[Route('/course/{idCourse}', name: 'app_course_show', methods: ['GET'])]
    public function show(Course $course): Response
    {
        return $this->render('course/show.html.twig', [
            'course' => $course,
        ]);
    }
    #[Route('/jeu', name: 'app_course_Jeu', methods: ['GET'])]
    public function Jeu(Request $request, Course $course): Response
    {
        return $this->render('course/Jeu.html.twig', [
            'course' => $course,
            'score' => $score,
        ]);
    }
    

    #[Route('/course/{idCourse}/edit', name: 'app_course_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Course $course, CourseRepository $courseRepository): Response
    {
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $courseRepository->save($course, true);

            return $this->redirectToRoute('app_course_showfr', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('course/edit.html.twig', [
            'course' => $course,
            'form' => $form,
        ]);
    }

    #[Route('/course/{idCourse}', name: 'app_course_delete', methods: ['POST'])]
    public function delete(Request $request, Course $course, CourseRepository $courseRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $course->getIdCourse(), $request->request->get('_token'))) {
            $courseRepository->remove($course, true);
        }

        return $this->redirectToRoute('app_course_showfr', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/show_in_map/{idCourse}', name: 'app_reservation_map', methods: ['GET'])]
    public function Map( Course $idCourse, EntityManagerInterface $entityManager ): Response
    {

        $course = $entityManager
            ->getRepository(Course::class)->findBy( 
                ['idCourse'=>$idCourse]
            );
        return $this->render('map/api_arcgis.html.twig', [
            'Course' => $course,
        ]);
    }
    #[Route('/', name: 'app_course_somme', methods: ['GET', 'POST'])]
    public function sommePrixCourses(EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Course::class);
        $prixTotal = $repository->createQueryBuilder('c')
            ->select('SUM(c.prix)')
            ->getQuery()
            ->getSingleScalarResult();

        return $this->render('course/showFront.html.twig', [
            'prixTotal' => $prixTotal
        ]);
    }
   
}

