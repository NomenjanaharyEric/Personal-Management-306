<?php

namespace App\Controller;

use App\Entity\Job;
use App\Form\JobType;
use App\Repository\JobRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobController extends AbstractController
{
    #[Route(path: "/job", name: "app_job", methods:["GET"])]
    /**
     * This methode allow us to get Job list with pagination
     *
     * @param JobRepository $jobRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(JobRepository $jobRepository, PaginatorInterface $paginator, Request $request):Response{
        $jobs = $paginator->paginate(
            $jobRepository->findAll(),
            $request->query->getInt("page", 1),
            10
        );
        return $this->render("pages/job/index.html.twig",[
            "jobs" => $jobs
        ]);
    }

    #[Route(path: "/job/show-{id}", name:"app_show_job", methods:["GET"])]
    /**
     * This methode allow us to get job information by this ID
     *
     * @param Job $job
     * @return Response
     */
    public function show(Job $job): Response
    {
        return $this->render("pages/job/show.html.twig",[
            "job" => $job
        ]);
    }

    #[Route(path: "/job/create", name:"app_create_job", methods:["GET","POST"])]
    /**
     * This methode allow us to create new Job
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager):Response
    {
        $job = new Job();
        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $job = $form->getData();
            $manager->persist($job);
            $manager->flush();

            $this->addFlash("success", "Nouveau Poste enregistrer avec success");

            return $this->redirectToRoute("app_job", [], 301);
        }

        return $this->render("pages/job/create.html.twig",[
            "form" => $form->createView()
        ]);
    }

    #[Route(path: "/job/update-{id}", name:"app_update_job", methods:["GET","POST"])]
    /**
     * This Methode Allow Us To Update Job By This ID
     *
     * @param Job $job
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function update(Job $job, Request $request, EntityManagerInterface $manager):Response
    {
        $form = $this->createForm(JobType::class, $job );
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $job = $form->getData();
            $manager->flush();

            $this->addFlash("success", "Poste mis à jour avec success");

            return $this->redirectToRoute("app_job", [], 301);
        }

        return $this->render("pages/job/update.html.twig",[
            "form" => $form->createView()
        ]);
    }

    #[Route(path: "/job/delete-{id}", name: "app_delete_job", methods:["GET"])]
    /**
     * This Methode Allow Us To Delete Job By This ID
     *
     * @param Job $job
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Job $job, EntityManagerInterface $manager): Response
    {
        $manager->remove($job);
        $manager->flush();

        $this->addFlash("success", "Poste supprimer avec success");

        return $this->redirectToRoute("app_job", [], 301);
    }
}
