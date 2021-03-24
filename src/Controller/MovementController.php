<?php

namespace App\Controller;

use App\Handler\MovementCreateHandler;
use App\Service\BankAccount\FindBankAccountsByUser;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class MovementController
{
    /**
     * @Route("/movement/create", name="movement_create")
     */
    public function create(
        Request $request,
        MovementCreateHandler $movementCreateHandler,
        FindBankAccountsByUser $findBankAccountsByUser,
        UrlGeneratorInterface $urlGenerator,
        Environment $twig

    ): Response {
        $options = ['bank_accounts' => $findBankAccountsByUser->findBankAccountsByUser()];
        if ($movementCreateHandler->handle($request, null, $options)){
            return new RedirectResponse($urlGenerator->generate('bank_account_list'));
        }

        return new Response($twig->render('movement/create.html.twig', [
            'form' => $movementCreateHandler->createView(),
        ]));
    }
}
