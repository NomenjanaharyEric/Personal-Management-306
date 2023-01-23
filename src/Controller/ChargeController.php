<?php

namespace App\Controller;

use App\Entity\Charge;
use App\Form\ChargeType;
use App\Repository\ChargeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChargeController extends AbstractController
{
    #[Route('/charge', name: 'app_charge', methods:["GET"])]
    /**
     * This Methode Allow Us To Get Charge List with pagination
     *
     * @param ChargeRepository $chargeRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(ChargeRepository $chargeRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $charges = $paginator->paginate(
            $chargeRepository->findAll(),
            $request->query->getInt("page", 1),
            10
        );

        return $this->render('pages/charge/index.html.twig', [
            'charges' => $charges,
        ]);
    }

    #[Route(path: "/charge/create", name: "app_create_charge", methods: ["GET", "POST"])]
    /**
     * This Methode Allow Us To Create New Charge
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $charge = new Charge();
        $form = $this->createForm(ChargeType::class, $charge);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $charge = $form->getData();
            
            $manager->persist($charge);
            $manager->flush();

            $this->addFlash("succes", "Nouveau Charge enregistrer avec success");

            return $this->redirectToRoute("app_charge", [], 301);
        }

        return $this->render("pages/charge/create.html.twig", [
            "form" => $form->createView()
        ]);
    }

    #[Route(path: "/charge/update-{id}", name: "app_update_charge", methods:["GET", "POST"])]
    /**
     * This Methode Allow Us To Update Charge Information By This ID
     *
     * @param Charge $charge
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function update(Charge $charge, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(ChargeType::class, $charge);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $charge = $form->getData();
            
            $manager->flush();

            $this->addFlash("success", "Charge Mis à jour avec success");

            return $this->redirectToRoute("app_charge", [], 301);
        }

        return $this->render("pages/charge/update.html.twig",[
            "form" => $form->createView()
        ]);
    }

    #[Route(path: "/charge/delete-{id}", name:"app_delete_charge", methods:["GET"])]
    /**
     * This Methode Allow Us To Delete Charge By This ID
     *
     * @param Charge $charge
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Charge $charge, EntityManagerInterface $manager): Response
    {
        $manager->remove($charge);
        $manager->flush();

        $this->addFlash("success", "Charge Supprimer avec success");

        return $this->redirectToRoute("app_charge", [], 301);
    }

}
