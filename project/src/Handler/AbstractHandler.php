<?php

namespace App\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;

Abstract class AbstractHandler
{
    private FormFactoryInterface $formFactory;
    protected FormInterface $form;
    protected EntityManagerInterface $em;

    abstract protected function getFormType(): string;

    abstract protected function process(?object $data): void;

    /**
     * @Required
     */
    public function setFormFactory(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @Required
     */
    public function setEntityManager(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function handle(Request $request, ?object $entity = null, $options = []): bool
    {
        $this->form = $this->formFactory->create($this->getFormType(), $entity, $options)->handleRequest($request);
        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $this->process($entity);

            return true;
        }

        return false;
    }

    public function createView(): FormView
    {
        return $this->form->createView();
    }
}
