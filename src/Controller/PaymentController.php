<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Repository\ContractRepository;
use App\Repository\DepartmentRepository;
use App\Repository\EmployeeRepository;
use App\Repository\JobRepository;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    #[Route('/payment', name: 'app_payment', methods:["GET"])]
    /**
     * This Methode allow us to get all employee under contract
     *
     * @param ContractRepository $contractRepository
     * @return Response
     */
    public function index(ContractRepository $contractRepository): Response
    {
        $employees = $contractRepository->getEmployeeUnderContract(status: "NOUVEAU");

        return $this->render('pages/payment/index.html.twig', [
            "employees" => $employees
        ]);
    }

    #[Route(path: 'payment/show-{id}', name: "app_payment_show", methods:["GET"])]
    /**
     * This Methode Allow us to get all information about an employee for his Payment
     *
     * @param ContractRepository $contractRepository
     * @param EmployeeRepository $employeeRepository
     * @param JobRepository $jobRepository
     * @param ServiceRepository $serviceRepository
     * @param DepartmentRepository $departmentRepository
     * @param Contract $contract
     * @param Int $id
     * @return Response
     */
    public function show(ContractRepository $contractRepository,EmployeeRepository $employeeRepository,JobRepository $jobRepository,ServiceRepository $serviceRepository,DepartmentRepository $departmentRepository ,Contract $contract ,Int $id): Response
    {
        $charges = $contractRepository->getChargesByContract($id);
        $taxes = $contractRepository->getTaxesByContract($id);
        $employee = $employeeRepository->findOneBy(['id' => $contract->getEmployee()]);
        $job = $jobRepository->findOneBy(['id' => $employee->getJob()]);
        $service = $serviceRepository->findOneBy(['id' => $job->getService()]);
        $department = $departmentRepository->findOneBy(['id' => $service->getDepartment()]);
        
        return $this->render('pages/payment/show.html.twig', [
            "contract" => $contract,
            "charges" => $charges,
            "taxes" => $taxes,
            "employee" => $employee,
            "job" => $job,
            "service" => $service,
            "department" => $department
        ]);
    }
}
