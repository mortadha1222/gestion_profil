<?php

namespace App\Controller;

use App\Entity\Actualities;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Knp\Component\Pager\PaginatorInterface;

use App\Entity\Events;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontEventsController extends AbstractController
{
    /**
     * @Route("/front_event", name="front_event")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $events = $this->getDoctrine()
            ->getRepository(Events::class)
            ->findAll();
        $events = $paginator->paginate(
            $events,
            $request->query->getInt('page', 1),
            4
        );
        return $this->render('front_event/index.html.twig', [
            'events' => $events,
        ]);

    }
    /**
     * @Route("/qr", name="qr", methods={"GET"})
     */
    public function Qr(): Response
    {

        $result = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data('')
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(300)
            ->margin(10)
            ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->logoPath(__DIR__ . '/assets/symfony.png')
            ->labelText('Work-It')
            ->labelFont(new NotoSans(20))
            ->labelAlignment(new LabelAlignmentCenter())
            ->build();
        $result->saveToFile(__DIR__ . '/qrcode.png');

        return $this->redirectToRoute('qr');




    }

}