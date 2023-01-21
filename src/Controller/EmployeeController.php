<?php

namespace App\Controller;

use App\Repository\EmployeeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployeeController extends AbstractController
{
    #[Route('/employee', name: 'app_employee', methods:["GET"])]
    public function index(EmployeeRepository $employeeRepository, PaginatorInterface $paginatorInterface, Request $request): Response
    {
        $employees = $paginatorInterface->paginate(
            $employeeRepository->findAll(),
            $request->query->getInt("page", 1),
            10
        );

        return $this->render('pages/employee/index.html.twig',[
            "employees" => $employees
        ]);
    }
}
