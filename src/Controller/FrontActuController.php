<?php

namespace App\Controller;
use Knp\Component\Pager\PaginatorInterface;

use App\Entity\Actualities;
use App\Entity\Events;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontActuController extends AbstractController
{
    /**
     * @Route("/front_actu", name="frontactu")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $actualities = $this->getDoctrine()
            ->getRepository(Actualities::class)
            ->findAll();
        $actualities = $paginator->paginate(
            $actualities,
            $request->query->getInt('page', 1),
            4
        );
        return $this->render('front_actu/index.html.twig', [
            'actualities' => $actualities,
        ]);
    }
}
