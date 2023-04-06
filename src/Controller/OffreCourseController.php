<?php

namespace App\Controller;

use App\Entity\OffreCourse;
use App\Form\OffreCourseType;
use App\Repository\OffreCourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/offre/course')]
class OffreCourseController extends AbstractController
{
    #[Route('/', name: 'app_offre_course_index', methods: ['GET'])]
    public function index(OffreCourseRepository $offreCourseRepository): Response
    {
        return $this->render('offre_course/index.html.twig', [
            'offre_courses' => $offreCourseRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_offre_course_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OffreCourseRepository $offreCourseRepository): Response
    {
        $offreCourse = new OffreCourse();
        $form = $this->createForm(OffreCourseType::class, $offreCourse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offreCourseRepository->save($offreCourse, true);

            return $this->redirectToRoute('app_offre_course_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('offre_course/new.html.twig', [
            'offre_course' => $offreCourse,
            'form' => $form,
        ]);
    }

    #[Route('/{idOffre}', name: 'app_offre_course_show', methods: ['GET'])]
    public function show(OffreCourse $offreCourse): Response
    {
        return $this->render('offre_course/show.html.twig', [
            'offre_course' => $offreCourse,
        ]);
    }

    #[Route('/{idOffre}/edit', name: 'app_offre_course_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, OffreCourse $offreCourse, OffreCourseRepository $offreCourseRepository): Response
    {
        $form = $this->createForm(OffreCourseType::class, $offreCourse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offreCourseRepository->save($offreCourse, true);

            return $this->redirectToRoute('app_offre_course_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('offre_course/edit.html.twig', [
            'offre_course' => $offreCourse,
            'form' => $form,
        ]);
    }

    #[Route('/{idOffre}', name: 'app_offre_course_delete', methods: ['POST'])]
    public function delete(Request $request, OffreCourse $offreCourse, OffreCourseRepository $offreCourseRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$offreCourse->getIdOffre(), $request->request->get('_token'))) {
            $offreCourseRepository->remove($offreCourse, true);
        }

        return $this->redirectToRoute('app_offre_course_index', [], Response::HTTP_SEE_OTHER);
    }
}
