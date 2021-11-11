<?php

namespace App\Handler\Movement;

use App\Entity\Category;
use App\Form\Movement\MovementAddCategoryType;
use App\Handler\AbstractHandler;
use Symfony\Component\Security\Core\Security;

class MovementAddCategoryHandler extends AbstractHandler
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function getFormType(): string
    {
        return MovementAddCategoryType::class;
    }

    protected function process(?object $entity): void
    {
        $newCategoryName = $this->form->get('new')->getData();
        if ($newCategoryName !== null) {
            $category = (new Category)
                ->setName($newCategoryName)
                ->setUser($this->security->getUser());

            $entity->setCategory($category);
            $this->em->persist($category);
        }

        $this->em->flush();
    }
}
