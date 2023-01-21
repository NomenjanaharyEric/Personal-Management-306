<?php

namespace App\Controller;

use App\Entity\Department;
use App\Form\DepartmentType;
use App\Repository\DepartmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class DepartmentController extends AbstractController
{
    /**
     * This method allow us to get department list function
     *
     * @param DepartmentRepository $departmentRepository
     * @param PaginatorInterface $paginatorInterface
     * @param Request $request
     * @return Response
     */
    #[Route('/department', name: 'app_department', methods:["GET"])]
    public function index(DepartmentRepository $departmentRepository, PaginatorInterface $paginatorInterface, Request $request): Response
    {
        $departments = $paginatorInterface->paginate(
            $departmentRepository->findAll(),
            $request->query->getInt("page", 1),
            5
        );
        return $this->render('pages/department/index.html.twig', [
            "departments" => $departments
        ]);
    }

    /**
     * This Methode allow us to create new Department
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/department/create', name: 'app_create_department', methods:['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $manager):Response
    {
        $department = new Department();
        $form = $this->createForm(DepartmentType::class, $department);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $department = $form->getData();
            $manager->persist($department);
            $manager->flush();

            $this->addFlash("success", "Nouveau departement enregistrer !!");

            return $this->redirectToRoute("app_department", [], 301);
        }

        return $this->render('pages/department/create.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * This Methode allow us to update Department
     *
     * @param Department $department
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/department/update-{id}', name:"app_update_department", methods:['GET', 'POST'])]
    public function update(Department $department, Request $request, EntityManagerInterface $manager):Response
    {
        $form = $this->createForm(DepartmentType::class, $department);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $department = $form->getData();

            $manager->flush();

            $this->addFlash('success', "Departement mis à jour");

            return $this->redirectToRoute("app_department", [], 301);
        }

        return $this->render("pages/department/update.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * This Methode allow us to delete Department by this ID
     *
     * @param Department $department
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/department/delete-{id}', name:'app_delete_department', methods:['GET', 'POST'])]
    public function delete(Department $department, EntityManagerInterface $manager): Response
    {
        $manager->remove($department);
        $manager->flush();

        $this->addFlash('success', "Departement supprimer !!");

        return $this->redirectToRoute('app_department', [], 301);
    }
}
