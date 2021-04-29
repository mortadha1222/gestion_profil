<?php

namespace App\Controller;
use App\Entity\Coach;
use App\Entity\Member;
use App\Repository\UserRepository;
use App\Entity\User;
use App\Form\UserType;
use App\Entity\Vendor;
use App\Security\UserAuthenticator;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use phpDocumentor\Reflection\Types\Integer;
use Swift_Mailer;
use Swift_Message;
use Swift_SendmailTransport;
use Swift_SmtpTransport;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use const http\Client\Curl\POSTREDIR_301;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Controller\CommandeController;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{

    /**
     * @Route("/", name="app_homepage" ,methods={"GET","POST"})
     */
    public function homepage(Request $request,UserRepository $repository):Response
    {

      $users = $repository->findAllPublishedOrderedByNewest();

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }
    /**
     * @Route("/imp", name="app_imp")
     */
    public function imp(UserRepository $repository)
    {
        $users = $repository->findAllPublishedOrderedByNewest();
        return $this->render('user/imp2.html.twig', [
            'users' => $users,
        ]);
    }
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(): Response
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder,\Swift_Mailer $mailer): Response
    {
        $user = new User();
        $vendor = new Vendor();
        $member = new Member();
        $coach = new Coach();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $password = $user->getPassword();
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $entityManager->flush();
            $role=$user->getRole();
            if($role=="Vendor")
            {
                $results = $this->getDoctrine()
                    ->getRepository(User::class)->findBy(array(),array('idUser'=>'DESC'),1,0);
                $a=$results[0];
                $vendor->setIdUser($a);
                $entityManager->persist($vendor);
                $entityManager->flush();
            }
            elseif ($role=="Member")
            {
                $results = $this->getDoctrine()
                    ->getRepository(User::class)->findBy(array(),array('idUser'=>'DESC'),1,0);
                $a=$results[0];
                $member->setIdUser($a);
                $entityManager->persist($member);
                $entityManager->flush();
            }
            else
            {
                $results = $this->getDoctrine()
                    ->getRepository(User::class)->findBy(array(),array('idUser'=>'DESC'),1,0);
                $a=$results[0];
                $coach->setIdUser($a);
                $entityManager->persist($coach);
                $entityManager->flush();
            }
            $email= $user->getEmail();
            $username = $user->getUsername();
            $message= (new \Swift_Message('test'))
                ->setFrom('work.itpidev@gmail.com')
                ->setTo($email)
                ->setSubject("Account name  ".$username."  Registred")
                ->setBody("your username is :".$username."your password is :".$password);
            $mailer->send($message);
            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
   /*
    public function statAction()
    {
        $pieChart = new PieChart();
        $datas = $this->getDoctrine()->getRepository(UserRepository::class)->findAll();
        foreach ($datas as $data) {
            $role += $data->getTemps();
        $username += $data->getTempLibre();
    }
        $pieChart->getData()->setArrayToDataTable( array(
            //  ['Roles', 'How Many Roles'],
            ['Roles', $role],
            ['Username',$username],
        ));
        dump($data); die();
        $pieChart->getOptions()->setTitle('Roles Stats');
        $pieChart->getOptions()->setHeight(400);
        $pieChart->getOptions()->setWidth(400);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#07600');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(25);


        return $this->render('stats.html.twig', array(
                'piechart' => $pieChart,
            )

        );
    }*/
    /**
     * @Route("/{username}", name="user_show2", methods={"GET"})
     */
    public function show2(User $user): Response
    {
        return $this->render('user/show2.html.twig', [
            'user' => $user,
        ]);
    }
    /**
     * @Route("/count_users", name="count_users")
     */
    public function countusers()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository(UserRepository::class);
        $total_users = $query->createQueryBuilder('a')
            ->select('count(a.idUser)')
            ->getQuery()
            ->getSingleScalarResult();
        return new Response($total_users);
    }
    /**
     * @Route("/trie_ASC", name="trie_ASC")
     */
    public function TrieASC(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT u FROM App\Entity\User u 
            ORDER BY u.idUser'
        );
        $users = $query->getResult();
        return $this->render('user/index.html.twig',
            array('users' => $users));

    }

    /**
     * @Route("/{idUser}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/recherche/{username}",name="recherche")
     */
    public function recherche($username): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $query= $entityManager->createQuery(
            'SELECT u
                FROM App\Entity\User u
                WHERE u.username = :query '
        )
            ->setParameter('query', $username);
        $users=$query->getResults();
        return $this->render('user/index.html.twig',array('user'=>$users));

    }
    /**
     * @Route("/{idUser}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, UserPasswordEncoderInterface $encoder): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/searchUserx ", name="searchUserx")
     */
    public function searchUserx(Request $request,NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $requestString=$request->get('searchValue');
        $users = $repository->findUserByUsername($requestString);
        $jsonContent = $Normalizer->normalize($users, 'json', ['groups' => 'users:read']);
        $a=json_encode($jsonContent);
        return new Response($a);

    }
    /**
     * @Route("/{idUser}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getIdUser(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }





}
