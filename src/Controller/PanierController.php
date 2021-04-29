<?php

namespace App\Controller;
use App\Entity\Produits;
use App\Entity\Panier;
use App\Entity\Commande;
use App\Form\PanierType;
use App\Controller\ProduitsController;
use App\Controller\CommandeController;


use phpDocumentor\Reflection\Types\Array_;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\Self_;
use phpDocumentor\Reflection\Types\This;
use PhpParser\Node\Scalar\String_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Helper\TableRows;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use google\appengine\api\mail\Message;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Stripe\Service\Checkout;
use function Sodium\add;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;
/**
 * @Route("/panier")
 */
class PanierController extends AbstractController
{
    /**
     * @Route("/", name="panier_controller_index", methods={"GET","POST"})
     */
    public function index(Request $request): Response
    {

        $table=  Array();
        $produits[] =new  Produits;
        $paniers = $this->getDoctrine()
            ->getRepository(Panier::class)
            ->findAll();
        $tot=0;
        $i=0;
        foreach ($paniers as $pan){
            $tot = $tot+ $pan->getTotal();
            $produits[$i] = $this->getDoctrine()
                ->getRepository(Produits::class)
                ->find($pan->getIdProduct());
            $table[$i]= ["idProduct"=>$pan->getIdProduct(),"title"=>$produits[$i]->getTitle(),"quantity"=> $pan->getQuantity(),"total"=>$pan->getTotal(),"idPanier"=>$pan->getIdPanier()];
            $i++;
        }
        if ($request->isMethod('POST')) {
            $adr=  $request->get('adr');

            $commande= new Commande();
            $commande->setAdresseLivraison($adr);
            $commande->setTotal($tot);
            $commande->setIdUser(1);
            $commande->setIdVendor(1);
            $commande->setUserName('mohamed');
            $commande->setVendorName('mourad');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commande);
            $entityManager->flush();


            $token = $request->request->get('stripeToken');
            \Stripe\Stripe::setApiKey("sk_test_51Ii7QjJkUISMkMB5RMhywJEsfp8gy2YE1QOb4Wv7G21kfXBPJuQY9m88GSSpBggG6jjfX1FIA5mZiBu6CoRfEquk00ZBIWT7Jx");
            \Stripe\Charge::create(array(
                "amount" => $tot * 100,
                "currency" => "usd",
                "source" => $token,
                "description" => "First test charge!"
            ));
            $this->addFlash('success', 'Order place successfully!');
            return $this->redirectToRoute('commande_index');
        }

        return $this->render('panier/index.html.twig', [
            'paniers' => $paniers,
            'tot'=> $tot,
            'produits'=> $produits,
            'table'=>$table,
            'i'=>0,
        ]);

    }
    /**
     * @Route("/rechercher/{title}", name="panier_controller_rechercher", methods={"GET","POST"})
     */
    public function rechercher( string $title): Response
    {
        $produits = $this->getDoctrine()
            ->getRepository(Produits::class)
            ->findByTitle($title);

          //  ->findOneBy($title);

        $paniers = $this->getDoctrine()
            ->getRepository(Panier::class)
            ->findAll();
          //  ->findOneBy($produits->getIdProduct);


        $table=  Array();
        $cart[]=new Panier();
        $tot=0;
        $i=0;
       // foreach ($produits as $pan){}
        foreach ($paniers as $pan){


            foreach ($produits as $prod){
                if($pan->getIdProduct()==$prod->getIdProduct()){
                    $table[$i]= ["idProduct"=>$pan->getIdProduct(),"title"=>$prod->getTitle(),"quantity"=> $pan->getQuantity(),"total"=>$pan->getTotal(),"idPanier"=>$pan->getIdPanier()];
                    $i++;

                    $tot = $tot+ $pan->getTotal();

                }

            }
        }
        return $this->render('panier/index.html.twig', [

            'tot'=> $tot,

            'table'=>$table,

        ]);
    }

    /**
     * @Route("/recherche/{title}", name="panier_controller_recherche", methods={"GET","POST"})
     */
    public function recherche( string $title): Response
    {   $paniers = $this->getDoctrine()
            ->getRepository(Panier::class)
            ->findAll();
        $produits = $this->getDoctrine()
            ->getRepository(Produits::class)
            ->findAll();
        $cart[]=new Panier();
        $tot=0;
        $c=0;
        foreach ($paniers as $pan){
            $i=0;
            foreach ($produits as $prod){
                if ($title==$prod->getTitle()){
                    $idProd[$i]=$prod->getIdProduct();
                $i++;
                }}

            foreach ($idProd as $id){
                if($pan->getIdProduct()==$id){
                $cart[$c]=$pan;
                $tot = $tot+ $pan->getTotal();
                $c++;
                }

            }
        }
        return $this->render('panier/index.html.twig', [
            'paniers' => $cart,
            'tot'=> $tot,
            'titre'=>$title
        ]);
    }

    /**
     * @Route("/new", name="panier_controller_new", methods={"GET","POST"})
     */
    public function new(Request $request ): Response
    {
        $panier = new Panier();
        $form = $this->createForm(PanierType::class, $panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($panier);
            $entityManager->flush();

            return $this->redirectToRoute('panier_controller_index');
        }


        return $this->render('panier/new.html.twig', [
            'panier' => $panier,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idPanier}", name="panier_controller_show", methods={"GET"})
     */
    public function show(Panier $panier): Response
    {
       // $this->mail();
        return $this->render('panier/show.html.twig', [
            'panier' => $panier,
        ]);
    }

    /**
     * @Route("/{idPanier}/edit", name="panier_controller_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Panier $panier): Response
    {
        $form = $this->createForm(PanierType::class, $panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('panier_controller_index');
        }

        return $this->render('panier/edit.html.twig', [
            'panier' => $panier,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{idPanier}", name="panier_controller_delete", methods={"POST"})
     */
    public function delete(Request $request, Panier $panier): Response
    {
        if ($this->isCsrfTokenValid('delete'.$panier->getIdPanier(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($panier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('panier_controller_index');
    }
    /**
     * @Route("/checkout", name="panier_checkout")
     */
    public function checkout(Request $request) :Response
    {


        if ($request->isMethod('POST')) {
            $token = $request->request->get('stripeToken');
            \Stripe\Stripe::setApiKey("sk_test_51Ii7QjJkUISMkMB5RMhywJEsfp8gy2YE1QOb4Wv7G21kfXBPJuQY9m88GSSpBggG6jjfX1FIA5mZiBu6CoRfEquk00ZBIWT7Jx");
            \Stripe\Charge::create(array(
                "amount" => $this->get('shopping_cart')->getTotal() * 100,
                "currency" => "usd",
                "source" => $token,
                "description" => "First test charge!"
            ));
            $this->addFlash('success', 'Order place successfully!');
        }

    }

    public function  mail():Response
    {// Notice that $image_content_id is the optional Content-ID header value of the
     // attachment. Must be enclosed by angle brackets (<>)
        $image_content_id = '<image-content-id>';

     // Pull in the raw file data of the image file to attach it to the message.
      //  $image_data = file_get_contents('image.jpg');
        try {
            $message = new Message();
            $message->setSender('workit.noreplay2021@gmail.com');
            $message->addTo('mohamed.mannai3@esprit.tn');
            $message->setSubject('Example email');
            $message->setTextBody('Hello, Order passed');
            $message->addAttachment('image.jpg', $image_data, $image_content_id);
            $message->send();
            echo 'Mail Sent';
        } catch (InvalidArgumentException $e) {
            echo 'There was an error';
        }
    }

    /**
     * @Route("/", name="panier_controller_newPan", methods={"GET","POST"})
     */
    public function newPan($produit):Response
    {
        $panier = new Panier();
        $x=$produit->getIdProduct();
        $y=$produit->getPrice();
        $panier->setIdProduct( $x);
        $panier->setIdUser(2);
        $panier->setQuantity(2);
        $panier->setTotal($y);


        $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($panier);
            $entityManager->flush();

      return $this->redirectToRoute('panier_controller_index');


    }
    /**
     * @Route( "/ajouter/{idProduct}", name="panier_ajouter", methods={"GET","POST"})
     */
    public function ajouter($idProduct):Response
    {  $produit= new Produits();
       $pantest = new Panier();
       $pantest = $this->getDoctrine()
                        ->getRepository(Panier::class)
                        ->find($idProduct);
       if (is_null($pantest)){
           $produit = $this->getDoctrine()
               ->getRepository(Produits::class)
               ->find($idProduct);
           $panier = new Panier();
           $x=$produit->getIdProduct();
           $y=$produit->getPrice();
           $panier->setIdProduct( $x);
           $panier->setIdUser(1);
           $panier->setQuantity(1);
           $panier->setTotal($y);
           $entityManager = $this->getDoctrine()->getManager();
           $entityManager->persist($panier);
           $entityManager->flush();
           $this->addFlash('success', 'Product added successfully!');

        }
       else{
           $this->addFlash('success', 'mawjoud  :');
       }

        return $this->redirectToRoute('panier_controller_index');
    }
}
