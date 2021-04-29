<?php

namespace App\Controller;

use App\Entity\Planning;
use App\Form\Planning1Type;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/front/planning")
 */
class FrontPlanningController extends AbstractController
{
    /**
     * @Route("/", name="front_planning_index", methods={"GET"})
     */
    public function index(): Response
    {
        $plannings = $this->getDoctrine()
            ->getRepository(Planning::class)
            ->findAll();

        return $this->render('front_planning/index.html.twig', [
            'plannings' => $plannings,
        ]);
    }
     /**
     * @Route("/triPlanningName", name="triPlanningName")
     */
    public function Trinom(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery(
            'SELECT e FROM App\Entity\Planning e 
            ORDER BY e.coachName'
        );
    }

    /**
     * @Route("/new", name="front_planning_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $planning = new Planning();
        $form = $this->createForm(Planning1Type::class, $planning);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($planning);
            $entityManager->flush();

            return $this->redirectToRoute('front_planning_index');
        }

        return $this->render('front_planning/new.html.twig', [
            'planning' => $planning,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idPlanning}", name="front_planning_show", methods={"GET"})
     */
    public function show(Planning $planning): Response
    {
        return $this->render('front_planning/show.html.twig', [
            'planning' => $planning,
        ]);
    }

    /**
     * @Route("/{idPlanning}/edit", name="front_planning_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Planning $planning): Response
    {
        $form = $this->createForm(Planning1Type::class, $planning);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('front_planning_index');
        }

        return $this->render('front_planning/edit.html.twig', [
            'planning' => $planning,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idPlanning}", name="front_planning_delete", methods={"POST"})
     */
    public function delete(Request $request, Planning $planning): Response
    {
        if ($this->isCsrfTokenValid('delete'.$planning->getIdPlanning(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($planning);
            $entityManager->flush();
        }

        return $this->redirectToRoute('front_planning_index');
    }
}
