<?php

namespace App\Tests\Controller;

use App\Tests\AbstractWebTestCase;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;

class RegistrationControllerTest extends AbstractWebTestCase
{
    use FixturesTrait;

    public function testDisplayRegistration()
    {
        $this->request('/registration');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1', 'S\'inscrire');
    }

    public function testSuccessfullRegister()
    {
        $crawler = $this->request('/registration');
        $this->loadFixtureFiles([dirname(__DIR__).'/fixtures/user.yaml']);

        $form = $this->handleRegisterForm($crawler, 'register@doe.fr', '00000000', '00000000');

        $this->submitThenRedirect($form, '/');
        $this->assertSelectorExists('h1', 'Hello');
    }

    public function testInvalidRegisterUsedEmail()
    {
        $crawler = $this->request('/registration');
        $this->loadFixtureFiles([dirname(__DIR__).'/fixtures/user.yaml']);

        $form = $this->handleRegisterForm($crawler, 'used@test.fr', '00000000', '00000000');
        $this->submitInvalidForm($form);
    }

    public function testInvalidRegisterNotSamePassword()
    {
        $crawler = $this->request('/registration');
        $this->loadFixtureFiles([dirname(__DIR__).'/fixtures/user.yaml']);

        $form = $this->handleRegisterForm($crawler, 'new@test.fr', '000000000000', '00000000');
        $this->submitInvalidForm($form);
    }

    public function testInvalidRegisterTooShortPassword()
    {
        $crawler = $this->request('/registration');
        $this->loadFixtureFiles([dirname(__DIR__).'/fixtures/user.yaml']);

        $form = $this->handleRegisterForm($crawler, 'new@test.fr', '10000000', '00000000');
        $this->submitInvalidForm($form);
    }

    private function handleRegisterForm(
        Crawler $crawler,
        string $email,
        string $passwordFirst,
        string $passwordSecond
    ){
        return $crawler->selectButton('valider')->form(
            [
                'user' =>
                    [
                        'email' => $email,
                        'plainPassword' =>
                        [
                            'first' => $passwordFirst,
                            'second' => $passwordSecond
                        ]
                    ]
            ]
        );
    }

}
