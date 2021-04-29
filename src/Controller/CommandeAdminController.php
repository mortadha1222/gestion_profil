<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
/**
 * @Route("/commande_admin")
 */
class CommandeAdminController extends AbstractController
{
    /**
     * @Route("/", name="commande_admin_index", methods={"GET"})
     */
    public function index(): Response
    {
        $commandes = $this->getDoctrine()
            ->getRepository(Commande::class)
            ->findAll();

        return $this->render('commande_admin/index.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    /**
     * @Route("/cmdPdf/{idCommande}", name="commande_admin_cmdPdf", methods={"GET","POST"})
     */
    public function cmdPdf($idCommande): Response
    {

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $commandes = $this->getDoctrine()
            ->getRepository(Commande::class)
            ->find($idCommande);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('commande_admin/cmdPdf.html.twig', [
            'commandes' => $commandes,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("facture.pdf", [
            "Attachment" => true
        ]);

    }
    /**
     * @Route("/{idCommande}", name="commande_admin_show", methods={"GET"})
     */
    public function show(Commande $commande): Response
    {
        return $this->render('commande_admin/show.html.twig', [
            'commande' => $commande,
        ]);
    }
    /**
     * @Route("/{idCommande}", name="commande_admin_delete", methods={"POST"})
     */
    public function delete(Request $request, Commande $commande): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getIdCommande(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('commande_admin_index');
    }



}
