<?php

namespace App\Controller;

use App\Repository\ContractRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    #[Route('/payment', name: 'app_payment', methods:["GET"])]
    public function index(ContractRepository $contractRepository): Response
    {
        $employees = $contractRepository->getEmployeeUnderContract(status: "NOUVEAU");
        // dd($employees);
        return $this->render('pages/payment/index.html.twig', [
            "employees" => $employees
        ]);
    }
}
