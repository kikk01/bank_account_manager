<?php

namespace App\Controller;

use App\Entity\BankAccount;
use App\Repository\BankAccountRepository;
use App\Service\BankAccount\BankAccountHandlerService;
use App\Service\BankAccount\BankAccountAddHandlerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BankAccountController extends AbstractController
{
    /**
     * @Route("/bank-account/list", name="bank_account_list")
     */
    public function list() :Response
    {
        $user = $this->getUser();

        return $this->render('bank_account/list.html.twig');
    }


    /**
     * @Route("/bank-account/create", name="bank_account_create")
     */
    public function create(Request $request, BankAccountHandlerService $bankAccountHandlerService): Response
    {
        $bankAccount = new BankAccount;

        if ($bankAccountHandlerService->handle($request, $bankAccount)) {
            return $this->redirectToRoute('home');
        }

        return $this->render('bank_account/create.html.twig', [
            'form' => $bankAccountHandlerService->createView()
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
