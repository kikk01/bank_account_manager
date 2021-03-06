<?php

namespace App\Controller;

use App\Entity\BankAccount;
use App\Handler\Movement\MovementCreateHandler;
use App\Service\BankAccount\FindBankAccountsByUser;
use App\Service\MovementService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;

class MovementController
{
    private RequestStack $request;

    private Environment $twig;

    private Security $security;

    public function __construct(RequestStack $request, Environment $twig, Security $security)
    {
        $this->request = $request;
        $this->twig = $twig;
        $this->security = $security;
    }

    /**
     * @Route("/bank-account/{id}/movement/list", name="movement_list")
     */
    public function list(BankAccount $bankAccount, MovementService $movementService): Response
    {
        if ($this->security->getUser() !== $bankAccount->getUser()) {
            throw new AccessDeniedException();
        }

        return New Response($this->twig->render('movement/list/list.html.twig', [
            'bankAccount' => $bankAccount,
            'movements' => $movementService->getMovementsByBankAccount($bankAccount)
        ]));
    }

    /**
     * @Route("/movement/create", name="movement_create")
     */
    public function create(
        MovementCreateHandler $movementCreateHandler,
        FindBankAccountsByUser $findBankAccountsByUser,
        UrlGeneratorInterface $urlGenerator
    ): Response {
        $options = ['bank_accounts' => $findBankAccountsByUser->findBankAccountsByUser()];
        if ($movementCreateHandler->handle($this->request->getCurrentRequest(), null, $options)){
            return new RedirectResponse($urlGenerator->generate('bank_account_list'));
        }

        return new Response($this->twig->render('movement/create.html.twig', [
            'form' => $movementCreateHandler->createView(),
        ]));
    }
}
