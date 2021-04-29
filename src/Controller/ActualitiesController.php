<?php

namespace App\Controller;

use App\Entity\Actualities;
use App\Form\ActualitiesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/actualities")
 */
class ActualitiesController extends AbstractController
{
    /**
     * @Route("/", name="actualities_index", methods={"GET"})
     */
    public function index(): Response
    {
        $actualities = $this->getDoctrine()
            ->getRepository(Actualities::class)
            ->findAll();

        return $this->render('actualities/index.html.twig', [
            'actualities' => $actualities,
        ]);
    }

    /**
     * @Route("/new", name="actualities_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $actuality = new Actualities();
        $form = $this->createForm(ActualitiesType::class, $actuality);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $photoAct = $request->files->get('actualities')['photoAct'];
            $uploads_directory = $this->getParameter('uploads_directory');

            $filename = md5(uniqid()) . '.' . $photoAct->guessExtension();
            $photoAct->move(
                $uploads_directory,
                $filename
            );
            
            $entityManager = $this->getDoctrine()->getManager();

            $actuality->setPhotoAct($filename);

            $entityManager->persist($actuality);
            $entityManager->flush();

            return $this->redirectToRoute('actualities_index');
        }

        return $this->render('actualities/new.html.twig', [
            'actuality' => $actuality,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idAct}", name="actualities_show", methods={"GET"})
     */
    public function show(Actualities $actuality): Response
    {
        return $this->render('actualities/show.html.twig', [
            'actuality' => $actuality,
        ]);
    }

    /**
     * @Route("/{idAct}/edit", name="actualities_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Actualities $actuality): Response
    {
        $form = $this->createForm(ActualitiesType::class, $actuality);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('actualities_index');
        }

        return $this->render('actualities/edit.html.twig', [
            'actuality' => $actuality,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idAct}", name="actualities_delete", methods={"POST"})
     */
    public function delete(Request $request, Actualities $actuality): Response
    {
        if ($this->isCsrfTokenValid('delete'.$actuality->getIdAct(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($actuality);
            $entityManager->flush();
        }

        return $this->redirectToRoute('actualities_index');
    }
}
