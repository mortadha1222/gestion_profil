<?php

namespace App\Controller;

use App\Entity\Suggestion;
use App\Form\Suggestion1Type;
use App\Form\SuggestionType;
use App\Repository\SuggestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/suggestion")
 */
class SuggestionController extends AbstractController
{
    /**
     * @Route("/", name="suggestion_index", methods={"GET"})
     */
    public function index(SuggestionRepository $suggestionRepository): Response
    {
        return $this->render('suggestion/index.html.twig', [
            'suggestions' => $suggestionRepository->findAll(),
        ]);
    }
    /**
     * @Route("/adminsuggestion", name="suggestion_index_admin", methods={"GET"})
     */
    public function indexAdmin(SuggestionRepository $suggestionRepository): Response
    {
        return $this->render('suggestion/admin.html.twig', [
            'suggestions' => $suggestionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="suggestion_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $suggestion = new Suggestion();
        $form = $this->createForm(Suggestion1Type::class, $suggestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($suggestion);
            $entityManager->flush();

            return $this->redirectToRoute('suggestion_index');
        }

        return $this->render('suggestion/new.html.twig', [
            'suggestion' => $suggestion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="suggestion_show", methods={"GET"})
     */
    public function show(Suggestion $suggestion): Response
    {
        return $this->render('suggestion/show.html.twig', [
            'suggestion' => $suggestion,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="suggestion_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Suggestion $suggestion): Response
    {
        $form = $this->createForm(Suggestion1Type::class, $suggestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('suggestion_index');
        }

        return $this->render('suggestion/edit.html.twig', [
            'suggestion' => $suggestion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin{id}", name="suggestion_delete_admin", methods={"POST"})
     */
    public function deleteAdmin(Request $request, Suggestion $suggestion): Response
    {
        if ($this->isCsrfTokenValid('delete'.$suggestion->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($suggestion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('suggestion_index_admin');
    }

    /**
     * @Route("/{id}", name="suggestion_delete", methods={"POST"})
     */
    public function delete(Request $request, Suggestion $suggestion): Response
    {
        if ($this->isCsrfTokenValid('delete'.$suggestion->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($suggestion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('suggestion_index');
    }

    /**
     * @Route("/{id}/answerAdmin", name="suggestion_answer", methods={"GET","POST"})
     */
    public function editAdmin(Request $request, Suggestion $suggestion): Response
    {
        $form = $this->createForm(SuggestionType::class, $suggestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('suggestion_index_admin');
        }

        return $this->render('suggestion/answer.html.twig', [
            'suggestion' => $suggestion,
            'form' => $form->createView(),
        ]);
    }
}
