<?php

namespace App\Controller\Ajax;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Movement;
use App\Handler\Movement\MovementAddCategoryHandler;
use App\Handler\Movement\MovementCreateCategoryHandler;
use App\Service\FindCategoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class MovementAddCategoryController
{
    private RequestStack $request;
    private Environment $twig;
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(RequestStack $request, Environment $twig, UrlGeneratorInterface $urlGenerator)
    {
        $this->request = $request;
        $this->twig = $twig;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @Route("/movement/{id}/category-add", name="movement_category_add_ajax", options={"expose" = true})
     */
    public function movementAddCategory(
        Movement $movement,
        FindCategoryService $findCategoryService,
        MovementAddCategoryHandler $movementAddCategoryHandler
    ){
        $options = ['categories' => $findCategoryService->findCategoriesByUSer()];

        if ($movementAddCategoryHandler->handle($this->request->getCurrentRequest(), $movement,  $options)){
            return new RedirectResponse($this->urlGenerator->generate(
                'movement_list', ['id' => $movement->getBankAccount()->getId()]
            ));
        }

        return new JsonResponse([$this->twig->render('movement/list/includes/category_add.html.twig', [
            'form' => $movementAddCategoryHandler->createView(),
            'movementId' => $movement->getId()
        ])]);
    }
}
