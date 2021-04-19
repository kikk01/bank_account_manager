<?php

namespace App\Service;

use App\Repository\CategoryRepository;
use Symfony\Component\Security\Core\Security;

class FindCategoryService
{
    private CategoryRepository $categoryRepository;

    private Security $security;

    public function __construct(CategoryRepository $categoryRepository, Security $security)
    {
        $this->categoryRepository = $categoryRepository;
        $this->security = $security;
    }

    public function findCategoriesByUSer()
    {
        return $this->categoryRepository->findByUser($this->security->getUser());
    }
}
