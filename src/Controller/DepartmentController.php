<?php

namespace App\Controller;

use App\Repository\DepartmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DepartmentController extends AbstractController
{
    #[Route('/department', name: 'app_department')]
    public function index(DepartmentRepository $departmentRepository): Response
    {
        $departments = $departmentRepository->findAll();
        return $this->render('pages/department/index.html.twig', [
            "departments" => $departments
        ]);
    }

}
