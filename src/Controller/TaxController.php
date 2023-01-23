<?php

namespace App\Controller;

use App\Entity\Tax;
use App\Form\TaxType;
use App\Repository\TaxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaxController extends AbstractController
{
    #[Route(path: '/tax', name: 'app_tax', methods:["GET"])]
    /**
     * This Methode Allow Us To Get Taxes List
     *
     * @param TaxRepository $taxRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(TaxRepository $taxRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $taxes = $paginator->paginate(
            $taxRepository->findAll(),
            $request->query->getInt("page", 1),
            5
        );
        return $this->render('pages/tax/index.html.twig', [
            'taxes' => $taxes
        ]);
    }

    #[Route(path: "/tax/create", name: "app_create_tax", methods: ["GET", "POST"])]
    /**
     * This Methode Allow Us To Create New Tax
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $tax = new Tax();
        $form = $this->createForm(TaxType::class, $tax);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $tax = $form->getData();

            $manager->persist($tax);
            $manager->flush();

            $this->addFlash("success", "Nouveau Taxe enregistrer");

            return $this->redirectToRoute("app_tax", [], 301);
        }

        return $this->render("pages/tax/create.html.twig",[
            "form" => $form->createView()
        ]);
    }

    #[Route(path: "/tax/update-{id}", name: "app_update_tax", methods: ["GET","POST"])]
    /**
     * This Methode Allow Us To Update Tax Information
     *
     * @param Tax $tax
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function update(Tax $tax, Request $request ,EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(TaxType::class, $tax);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $tax = $form->getData();

            $manager->flush();

            $this->addFlash("success", "Taxe Mis à Jour avec Success");

            return $this->redirectToRoute("app_tax", [], 301);
        }

        return $this->render("pages/tax/update.html.twig",[
            "form" => $form->createView()
        ]);
    }

    #[Route(path: "/tax/delete-{id}", name: "app_delete_tax", methods: ["GET"])]
    /**
     * This Methode Allow Us To Delete Tax By This ID
     *
     * @param Tax $tax
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Tax $tax, EntityManagerInterface $manager): Response
    {
        $manager->remove($tax);
        $manager->flush();

        $this->addFlash("success", "Taxe supprimer avec success");

        return $this->redirectToRoute("app_tax", [], 301);
    }
}
