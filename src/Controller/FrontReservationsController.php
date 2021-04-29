<?php

namespace App\Controller;

use App\Entity\Reservations;
use App\Form\Reservations1Type;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/front/reservations")
 */
class FrontReservationsController extends AbstractController
{
    /**
     * @Route("/", name="front_reservations_index", methods={"GET"})
     */
    public function index(): Response
    {
        $reservations = $this->getDoctrine()
            ->getRepository(Reservations::class)
            ->findAll();

        return $this->render('front_reservations/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    /**
     * @Route("/new", name="front_reservations_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $reservation = new Reservations();
        $form = $this->createForm(Reservations1Type::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('front_reservations_index');
        }

        return $this->render('front_reservations/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idReservation}", name="front_reservations_show", methods={"GET"})
     */
    public function show(Reservations $reservation): Response
    {
        return $this->render('front_reservations/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * @Route("/{idReservation}/edit", name="front_reservations_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reservations $reservation): Response
    {
        $form = $this->createForm(Reservations1Type::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('front_reservations_index');
        }

        return $this->render('front_reservations/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idReservation}", name="front_reservations_delete", methods={"POST"})
     */
    public function delete(Request $request, Reservations $reservation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getIdReservation(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('front_reservations_index');
    }
}
