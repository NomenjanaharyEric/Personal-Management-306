<?php

namespace App\Controller;

use App\Repository\DepartmentRepository;
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

}
