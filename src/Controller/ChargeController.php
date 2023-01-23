<?php

namespace App\Controller;

use App\Repository\ChargeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChargeController extends AbstractController
{
    #[Route('/charge', name: 'app_charge', methods:["GET"])]
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
}
