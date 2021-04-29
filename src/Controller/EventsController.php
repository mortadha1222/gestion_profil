<?php

namespace App\Controller;

use App\Entity\Events;
use App\Repository\EventsRepository;
use App\Form\EventsType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;



/**
 * @Route("/events")
 */
class EventsController extends AbstractController
{


    /**
     * @Route("/pdfevents", name="pdfevents",methods={"GET"})
     */
    public function pdf(EventsRepository $eventsrepository):Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('extras/pdf.html.twig', [
            'events' => $eventsrepository->findAll()
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
    }

    /**
     * @Route("/", name="events_index", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $events = $this->getDoctrine()
            ->getRepository(Events::class)
            ->findAll();
            $events = $paginator->paginate(
            $events,
            $request->query->getInt('page',1),
            3
        );

        return $this->render('events/index.html.twig', [
            'events' => $events,
        ]);

    }
 

    /**
     * @Route("/triEventsNom", name="triEventsNom")
     */
    public function Trinom(Request $request,PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery(
            'SELECT e FROM App\Entity\Events e 
            ORDER BY e.nameEve'
        );

        $events = $query->getResult();
        $events = $paginator->paginate(
            $events,
            $request->query->getInt('page',1),
            4
        );
        return $this->render('events/index.html.twig',
            array('events' => $events));

    }

    
    /**
     * @Route("/new", name="events_new", methods={"GET","POST"})
     */
    public function new(Request $request, \Swift_Mailer $mailer): Response
    {
        $event = new Events();
        $form = $this->createForm(EventsType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            

          
             $photoEve = $request->files->get('events')['photoEve'];
            $uploads_directory = $this->getParameter('uploads_directory');

            $filename = md5(uniqid()) . '.' . $photoEve->guessExtension();
            $photoEve->move(
                $uploads_directory,
                $filename

            );

            
            
            $entityManager = $this->getDoctrine()->getManager();


            $event->setPhotoEve($filename);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            $message= (new \Swift_Message('test'))

            ->setFrom('work.itpidev@gmail.com')
            ->setTo('work.itpidev@gmail.com')
            ->setSubject('event confirmation')

            ->setBody('event added!');

                $mailer->send($message);


            return $this->redirectToRoute('events_index');
        }

        return $this->render('events/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idEvent}", name="events_show", methods={"GET"})
     */
    public function show(Events $event): Response
    {
        return $this->render('events/show.html.twig', [
            'event' => $event,
        ]);
    }

    /**
     * @Route("/{idEvent}/edit", name="events_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Events $event): Response
    {
        $form = $this->createForm(EventsType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('events_index');
        }

        return $this->render('events/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idEvent}", name="events_delete", methods={"POST"})
     */
    public function delete(Request $request, Events $event): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getIdEvent(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('events_index');
    }

  

}
