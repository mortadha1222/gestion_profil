<?php

namespace App\Controller;

use App\Entity\Partenaires;
use App\Form\PartenairesType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/partenaires")
 */
class PartenairesController extends AbstractController
{
    /**
     * @Route("/", name="partenaires_index", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $data = $this->getDoctrine()
            ->getRepository(Partenaires::class)
            ->findAll();
        $partenaires= $paginator->paginate(
            $data, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            1); // Nombre de résultats par page

        return $this->render('partenaires/front_partenaires.html.twig', [
            'partenaires' => $partenaires,
        ]);
    }
    /**
     * @Route("/backoffice", name="partenaires_backoffice_index", methods={"GET"})
     */
    public function back_office_index(): Response
    {
        $partenaires = $this->getDoctrine()
            ->getRepository(partenaires::class)
            ->findAll();

        return $this->render('partenaires/index.html.twig', [
            'partenaires' => $partenaires,
        ]);
    }

    /**
     * @Route("/new", name="partenaires_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $partenaire = new Partenaires();
        $form = $this->createForm(PartenairesType::class, $partenaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($partenaire);
            $entityManager->flush();

            return $this->redirectToRoute('partenaires_index');
        }

        return $this->render('partenaires/new.html.twig', [
            'partenaire' => $partenaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idPartenaire}", name="partenaires_show", methods={"GET"})
     */
    public function show(Partenaires $partenaire): Response
    {
        return $this->render('partenaires/show.html.twig', [
            'partenaire' => $partenaire,
        ]);
    }

    /**
     * @Route("/{idPartenaire}/edit", name="partenaires_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Partenaires $partenaire): Response
    {
        $form = $this->createForm(PartenairesType::class, $partenaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('partenaires_index');
        }

        return $this->render('partenaires/edit.html.twig', [
            'partenaire' => $partenaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idPartenaire}", name="partenaires_delete", methods={"POST"})
     */
    public function delete(Request $request, Partenaires $partenaire): Response
    {
        if ($this->isCsrfTokenValid('delete'.$partenaire->getIdPartenaire(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($partenaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('partenaires_index');
    }
}
