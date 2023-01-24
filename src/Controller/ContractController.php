<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Form\ContractType;
use App\Repository\ContractRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contract')]
class ContractController extends AbstractController
{
    #[Route('/', name: 'app_contract_index', methods: ['GET'])]
    /**
     * This Methode Allow Us To Get List Contract With Pagination
     *
     * @param ContractRepository $contractRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(ContractRepository $contractRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $contracts = $paginator->paginate(
            $contractRepository->findAll(),
            $request->query->getInt("page", 1),
            10
        );
        return $this->render('pages/contract/index.html.twig', [
            'contracts' => $contracts,
        ]);
    }

    #[Route('/new', name: 'app_contract_new', methods: ['GET', 'POST'])]
    /**
     * This Methode Allow Us To Create New Contract
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $contract = new Contract();
        $form = $this->createForm(ContractType::class, $contract);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contract = $form->getData();
            $manager->persist($contract);
            $manager->flush();

            $this->addFlash("success", "Nouveau contrat enregistrer");

            return $this->redirectToRoute('app_contract_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/contract/new.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route('/{id}', name: 'app_contract_show', methods: ['GET'])]
    /**
     *This Methode Allow Us Show All Contract Information
     *
     * @param Contract $contract
     * @return Response
     */
    public function show(Contract $contract): Response
    {
        return $this->render('pages/contract/show.html.twig', [
            'contract' => $contract,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contract_edit', methods: ['GET', 'POST'])]
    /**
     * This Methode Allow Us Update Contract Information
     *
     * @param Request $request
     * @param Contract $contract
     * @param ContractRepository $contractRepository
     * @return Response
     */
    public function edit(Request $request, Contract $contract, ContractRepository $contractRepository): Response
    {
        $form = $this->createForm(ContractType::class, $contract);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contractRepository->save($contract, true);

            $this->addFlash("success", "Modification  Contrat Enregistrer");

            return $this->redirectToRoute('app_contract_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/contract/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contract_delete', methods: ['POST'])]
    /**
     * This Methode Allow Us To Delete Contract By This ID
     *
     * @param Request $request
     * @param Contract $contract
     * @param ContractRepository $contractRepository
     * @return Response
     */
    public function delete(Request $request, Contract $contract, ContractRepository $contractRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contract->getId(), $request->request->get('_token'))) {
            $contractRepository->remove($contract, true);
            $this->addFlash("success", "Contrat Supprimer enregistrer");
        }

        return $this->redirectToRoute('app_contract_index', [], Response::HTTP_SEE_OTHER);
    }
}
