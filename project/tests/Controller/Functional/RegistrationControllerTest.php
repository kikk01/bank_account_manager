<?php

namespace App\Tests\Controller;

use App\Tests\AbstractWebTestCase;
use App\Tests\PathConstant;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;

class RegistrationControllerTest extends AbstractWebTestCase
{
    use FixturesTrait;

    public function testDisplayRegistration()
    {
        $this->request(PathConstant::REGISTRATION);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1', 'S\'inscrire');
    }

    public function testSuccessfullRegister()
    {
        $crawler = $this->request(PathConstant::REGISTRATION);
        $this->loadFixtureFiles([dirname(__DIR__, 2).'/fixtures/user.yaml']);

        $form = $this->handleRegisterForm($crawler, 'register@doe.fr', '00000000', '00000000');

        $this->submitThenRedirect($form, PathConstant::HOME);
        $this->assertSelectorExists('h1', 'Hello');
    }

    public function testInvalidRegisterUsedEmail()
    {
        $crawler = $this->request(PathConstant::REGISTRATION);
        $this->loadFixtureFiles([dirname(__DIR__, 2).'/fixtures/user.yaml']);

        $form = $this->handleRegisterForm($crawler, 'used@test.fr', '00000000', '00000000');
        $this->submitInvalidForm($form);
    }

    public function testInvalidRegisterNotSamePassword()
    {
        $crawler = $this->request(PathConstant::REGISTRATION);
        $this->loadFixtureFiles([dirname(__DIR__, 2).'/fixtures/user.yaml']);

        $form = $this->handleRegisterForm($crawler, 'new@test.fr', '000000000000', '00000000');
        $this->submitInvalidForm($form);
    }

    public function testInvalidRegisterTooShortPassword()
    {
        $crawler = $this->request(PathConstant::REGISTRATION);
        $this->loadFixtureFiles([dirname(__DIR__, 2).'/fixtures/user.yaml']);

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
