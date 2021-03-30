<?php

namespace App\Controller;

use App\Entity\BankAccount;
use App\Handler\BankAccount\BankAccountHandler;
use App\Service\BankAccount\FindBankAccountsByUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class BankAccountController
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/bank-account/list", name="bank_account_list")
     */
    public function list(FindBankAccountsByUser $findBankAccountsByUser): Response
    {
        return New Response($this->twig->render('bank_account/list.html.twig', [
            'bankAccounts' => $findBankAccountsByUser->findBankAccountsByUser()
        ]));
    }

    /**
     * @Route("/bank-account/create", name="bank_account_create")
     */
    public function create(
        Request $request,
        BankAccountHandler $bankAccountHandler,
        UrlGeneratorInterface $urlGenerator
    ): Response {
        if ($bankAccountHandler->handle($request, new BankAccount)) {
            return New RedirectResponse($urlGenerator->generate('bank_account_list'));
        }

        return New Response($this->twig->render('bank_account/create.html.twig', [
            'form' => $bankAccountHandler->createView()
        ]));
    }
}
