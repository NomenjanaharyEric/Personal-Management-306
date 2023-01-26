<?php

namespace App\Controller;

use App\Repository\EmployeeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    #[Route('/payment', name: 'app_payment', methods:["GET"])]
    public function index(EmployeeRepository $employeeRepository): Response
    {
        $employees = $employeeRepository->findEmployeesUnderContract();
        
        return $this->render('pages/payment/index.html.twig',[
            "employees" => $employees
        ]);
    }
}
