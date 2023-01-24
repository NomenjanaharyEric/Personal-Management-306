<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Form\CompteType;
use App\Repository\CompteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompteController extends AbstractController
{
    #[Route(path:'/compte', name: 'app_compte', methods:["GET"])]
    /**
     * This Methode Allow uS to Get All Compte list with pagination
     *
     * @param CompteRepository $compteRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(CompteRepository $compteRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $comptes = $paginator->paginate(
            $compteRepository->findAll(),
            $request->query->getInt("page", 1),
            10
        );

        return $this->render('pages/compte/index.html.twig', [
            'comptes' => $comptes
        ]);
    }

    #[Route(path: "/compte/create", name: "app_create_compte", methods: ["GET","POST"])]
    /**
     * This Methode Allow Us To Create Compte
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager):Response
    {
        $compte = new Compte();
        $form = $this->createForm(CompteType::class, $compte);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $compte = $form->getData();
            $manager->persist($compte);
            $manager->flush();

            $this->addFlash("success", "Nouveau compte créer avec success");

            return $this->redirectToRoute("app_compte", [], 301);

        }

        return $this->render("pages/compte/create.html.twig", [
            "form" => $form
        ]);
    }

    #[Route(path: "/compte/update-{id}", name:"app_update_compte", methods:["GET","POST"])]
    /**
     * This Methode Allow Us To Update Compte
     *
     * @param Compte $compte
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function update(Compte $compte, Request $request, EntityManagerInterface $manager):Response
    {
        $form = $this->createForm(CompteType::class, $compte);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $compte = $form->getData();
            $manager->flush();

            $this->addFlash("success", "Compte mis à jour");

            return $this->redirectToRoute("app_compte", [], 301);
        }

        return $this->render("pages/compte/update.html.twig",[
            "form" => $form
        ]);
    }

    #[Route(path: "/compte/delete-{id}", name:"app_delete_compte", methods:["GET"])]
    /**
     * This Methode Allow Us To Delete Compte
     *
     * @param Compte $compte
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Compte $compte, EntityManagerInterface $manager):Response
    {
        $manager->remove($compte);
        $manager->flush();
        
        $this->addFlash("success", "Compte supprimer avec success");

        return $this->redirectToRoute("app_compte", [], 301);
    }
}
