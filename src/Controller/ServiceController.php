<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    /**
     * This methode allow us to get Services list with pagination
     *
     * @param ServiceRepository $serviceRepository
     * @param PaginatorInterface $paginatorInterface
     * @param Request $request
     * @return Response
     */
    #[Route(path: '/service', name: 'app_service', methods:['GET'])]
    public function index(ServiceRepository $serviceRepository, PaginatorInterface $paginatorInterface, Request $request): Response
    {
        $services = $paginatorInterface->paginate(
            $serviceRepository->findAll(),
            $request->query->getInt("page", 1),
            5
        );

        return $this->render('pages/service/index.html.twig', [
            'services' => $services
        ]);
    }

    /**
     * This methode allow us to create new service
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route(path: '/service/create', name:'app_create_service', methods:["GET", "POST"])]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $service = $form->getData();
            $manager->persist($service);
            $manager->flush();

            $this->addFlash("success", "Nouveau Service créer avec success");

            return $this->redirectToRoute("app_service", [], 301);
        }

        return $this->render("pages/service/create.html.twig",[
            "form" => $form->createView()
        ]);
    }

    /**
     * This methode allow us to update servive
     * @param Service $service
     * @param Request $request
     * @param EntityManagerInterface $manager
     */
    #[Route(path: '/service/update-{id}', name:'app_update_service', methods:["GET", "POST"])]
    public function update(Service $service, Request $request, EntityManagerInterface $manager):Response
    {
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $service = $form->getData();
            $manager->flush();

            $this->addFlash('success', "Service mis à jour avec success !!");

            return $this->redirectToRoute("app_service", [], 301);
        }

        return $this->render("pages/service/update.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * This methode allow us to delete service by this ID
     *
     * @param Service $service
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route(path: "/service/delete-{id}", name: 'app_delete_service', methods:["GET"])]
    public function delete(Service $service, EntityManagerInterface $manager):Response
    {
        $manager->remove($service);
        $manager->flush();

        $this->addFlash("success", "Service supprimer avec success");

        return $this->redirectToRoute("app_service", [], 301);
    }
}
