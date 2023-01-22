<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Form\EmployeeType;
use App\Repository\EmployeeRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/employee/create', name:'app_create_employee',methods:["GET", "POST"] )]
    public function create(Request $request, EntityManagerInterface $manager):Response
    {
        $employee = new Employee();
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $employee = $form->getData();
            $manager->persist($employee);
            $manager->flush();

            $this->addFlash('success', "Nouveau employée enregistrer avec success");

            return $this->redirectToRoute("app_employee", [], 301);
        }

        return $this->render("/pages/employee/create.html.twig", [
            "form" => $form->createView()
        ]);
    }
}
