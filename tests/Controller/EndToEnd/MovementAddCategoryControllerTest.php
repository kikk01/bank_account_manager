<?php

namespace App\Tests\Controller\EndToEnd;

use App\Tests\PathConstant;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Component\Panther\PantherTestCase;
use Symfony\Component\Panther\Client as PantherClient;

class MovementAddCategoryControllerTest extends PantherTestCase
{
    use FixturesTrait;

    const SWITCH_BUTTON = 'button[data-action="selectFieldWithNewOption#switchField"]';

    static PantherClient $client;

    protected function setUp(): void
    {
        parent::setUp();
        static::$client = static::createPantherClient();
    }

    public function testDisplayFormWithUserOwnZeroCategories()
    {
        $this->loginThenRequestToMovementListEndTest('userownzerocategories@test.fr');
        $this->assertDisplayCategoryForm();

        $this->assertSelectorIsDisabled(self::SWITCH_BUTTON);
    }

    public function testSwitchButton()
    {
        $crawler = $this->loginThenRequestToMovementListEndTest();
        $this->assertDisplayCategoryForm();

        $this->assertSelectorIsEnabled(self::SWITCH_BUTTON);
        $this->assertSelectorExists('select[data-selectfieldwithnewoption-target="selectElt"]');
        $this->assertSelectorTextContains(self::SWITCH_BUTTON, 'Nouvelle catégorie');

        $crawler->selectButton('Nouvelle catégorie')->click();
        $this->assertSelectorExists('input[data-selectfieldwithnewoption-target="newInputElt"]');
        $this->assertSelectorTextContains(self::SWITCH_BUTTON, 'Sélectionner une catégorie');
    }

    public function testEmptyNewCategoryInputOnswitch()
    {
        $crawler = $this->loginThenRequestToMovementListEndTest();
        $this->assertDisplayCategoryForm();
        $crawler->selectButton('Nouvelle catégorie')->click();
        $form = $crawler->selectButton('valider')->form();
        $form->get('movement_add_category[new]')->setValue('xxxx');

        $crawler->selectButton('Sélectionner une catégorie')->click();
        $this->assertSame('', $form->get('movement_add_category[new]')->getValue());
    }


    private function loginThenRequestToMovementListEndTest($email='test@test.fr')
    {
        $crawler = static::$client->request('GET', PathConstant::LOGIN);

        $form = $crawler->selectButton('valider')->form([
            'login[email]' => $email, 'login[password]' => '00000000'
        ]);
        static::$client->submit($form);
        return static::$client->request('GET', PathConstant::MOVEMENT_LIST_END_TEST);

    }

    private function assertDisplayCategoryForm()
    {
        static::$client->clickLink('Non catégorisé');
        static::$client->waitFor('.btn-primary');
        $this->assertSelectorExists(self::SWITCH_BUTTON);
    }
}
