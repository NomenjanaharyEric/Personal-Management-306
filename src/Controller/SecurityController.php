<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/connexion', name: 'app_login', methods:["GET", "POST"])]
    /**
     * This Methode Allow Us To Login User
     *
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('pages/security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }


    #[Route(path: "/inscription", name: "app_register", methods: ["GET", "POST"])]
    /**
     * This Methode Allow Us To Register User
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function register(Request $request, EntityManagerInterface $manager): Response
    {
        $user = new User();
        $user->setRoles(['ROLE_USER']);

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();

            $manager->persist($user);
            $manager->flush();

            $this->addFlash("success", "Compte utilisateur créer avec success");

            return $this->redirectToRoute("app_login", [], 301);
        }

        return $this->render("pages/security/register.html.twig", [
            "form" => $form->createView()
        ]);
    }

    #[Route(path: '/deconnexion', name:"app_logout", methods:["GET"])]
    /**
     * This Methode Allow Us To Disconnect User
     *
     * @return void
     */
    public function logout()
    {
        // NOTHING TODO HERE
    }
}
