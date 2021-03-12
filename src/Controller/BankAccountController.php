<?php

namespace App\Controller;

use App\Entity\BankAccount;
use App\Handler\BankAccount\BankAccountHandler;
use App\Repository\BankAccountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BankAccountController extends AbstractController
{
    private BankAccountRepository $bankAccountRepository;

    public function __construct(BankAccountRepository $bankAccountRepository)
    {
        $this->bankAccountRepository = $bankAccountRepository;
    }

    /**
     * @Route("/bank-account/list", name="bank_account_list")
     */
    public function list() :Response
    {
        $user = $this->getUser();
        $bankAccounts = $this->bankAccountRepository->findByUser($user->getId());

        return $this->render('bank_account/list.html.twig', [
            'bankAccounts' => $bankAccounts
        ]);
    }


    /**
     * @Route("/bank-account/create", name="bank_account_create")
     */
    public function create(Request $request, BankAccountHandler $bankAccountHandler): Response
    {
        $bankAccount = new BankAccount;

        if ($bankAccountHandler->handle($request, $bankAccount)) {
            return $this->redirectToRoute('bank_account_list');
        }

        return $this->render('bank_account/create.html.twig', [
            'form' => $bankAccountHandler->createView()
        ]);
    }

    /**
     * @Route("/bank-account/{id}/read", name="bank_account_read")
     */
    public function read(BankAccount $bankAccount)
    {
        return $this->render('bank_account/read.html.twig', [
            'bankAccount' => $bankAccount
        ]);
    }
}
