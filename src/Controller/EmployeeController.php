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
    /**
     * This methode allow us to get paginate Employees
     *
     * @param EmployeeRepository $employeeRepository
     * @param PaginatorInterface $paginatorInterface
     * @param Request $request
     * @return Response
     */
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

    #[Route(path: "/employee/show-{id}", name: "app_show_employee", methods:["GET"])]
    /**
     * This Methode Allow Us To Show Employee Information
     *
     * @param Employee $employee
     * @return Response
     */
    public function show(Employee $employee):Response
    {
        return $this->render("/pages/employee/show.html.twig", [
            "employee" => $employee
        ]);
    }

    #[Route('/employee/create', name:'app_create_employee',methods:["GET", "POST"] )]
    /**
     * This methode allow us to create new Employee
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
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

    #[Route(path: "/employee/update-{id}", name: "app_update_employee", methods:["GET", "POST"])]
    /**
     * This methode allow us to update Employee information
     *
     * @param Employee $employee
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function update(Employee $employee, Request $request, EntityManagerInterface $manager): Response{
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $employee = $form->getData();
            $manager->flush();

            $this->addFlash('success', "Employée mis à jour !");

            return $this->redirectToRoute("app_employee", [], 301);
        }
        return $this->render("pages/employee/update.html.twig",[
            "form" => $form->createView()
        ]);
    }

    #[Route( path: "/employee/delete-{id}", name: "app_delete_employee", methods:["GET"])]
    /**
     * This methode allow us to delete Employee
     *
     * @param Employee $employee
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Employee $employee, EntityManagerInterface $manager): Response
    {
        $manager->remove($employee);
        $manager->flush();

        $this->addFlash('success', "Employée supprimer avec success");

        return $this->redirectToRoute("app_employee", [], 301);
    }
}
