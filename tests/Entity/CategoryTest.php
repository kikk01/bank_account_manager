<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use App\Tests\AbstractKernelTestCase;

class CategoryTest extends AbstractKernelTestCase
{
    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidNameTooLong()
    {
        $this->assertHasErrors($this->getEntity()->setName('azeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeaze'), 1);
    }

    private function getEntity()
    {
        return (new Category)->setName('categorie de test');
    }
}
