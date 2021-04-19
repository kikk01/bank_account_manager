<?php

namespace App\Handler\Movement;

use App\Form\Movement\MovementCreateType;
use App\Handler\AbstractHandler;
use App\Service\Movement\MovementCreateService;
use App\Utils\CsvExtractorUtils;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MovementCreateHandler extends AbstractHandler
{
    private MovementCreateService $movementCreateService;

    /**
     * @Required
     */
    public function setMovementListAddService(MovementCreateService $movementCreateService)
    {
        $this->movementCreateService = $movementCreateService;
    }

    protected function getFormType(): string
    {
        return MovementCreateType::class;
    }

    protected function process(?object $entity): void
    {
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $this->form->get('accountStatement')->getData();
        $csvExtractorUtils = new CsvExtractorUtils($uploadedFile->getPathname());
        $movementsList = $csvExtractorUtils->extract();

        $this->movementCreateService->create(
            $this->form->getData()->getBankAccount(),
            $movementsList
        );

        $this->em->flush();
    }
}
