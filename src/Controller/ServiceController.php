<?php

namespace App\Controller;

use App\Repository\ServiceRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    #[Route('/service', name: 'app_service', methods:['GET'])]
    public function index(ServiceRepository $serviceRepository, PaginatorInterface $paginatorInterface, Request $request): Response
    {
        $services = $paginatorInterface->paginate(
            $serviceRepository->findAll(),
            $request->query->getInt("page", 1),
            10
        );

        return $this->render('pages/service/index.html.twig', [
            'services' => $services
        ]);
    }
}
