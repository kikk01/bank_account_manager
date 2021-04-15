<?php

namespace App\Tests\Controller;

use App\Tests\AbstractWebTestCase;
use App\Tests\PathConstant;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends AbstractWebTestCase
{
    use FixturesTrait;

    public function testDisplayLogin()
    {
        $this->request(PathConstant::LOGIN);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1', 'Connection');
        $this->assertSelectorNotExists('.alert.alert-danger');
    }

    public function testLoginWithBadCredentials()
    {
        $crawler = $this->request(PathConstant::LOGIN);

        $form = $crawler->selectButton('valider')->form([
            'login' => ['email' => 'john@doe.fr', 'password' => 'fakepassword']
        ]);

        $this->submitThenRedirect($form, PathConstant::LOGIN);
        $this->assertSelectorExists('.alert.alert-danger');
    }

    public function testSuccessfullLogin()
    {
        $this->loadFixtureFiles([dirname(__DIR__) . '/fixtures/user.yaml']);

        $crawler = $this->request(PathConstant::LOGIN);
        $form = $crawler->selectButton('valider')->form([
            'login' => ['email' => 'used@test.fr', 'password' => '0000']
        ]);

        $this->submitThenRedirect($form, '/');
    }
}
