<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Security\LoginFormAuthenticathorAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\AuthenticatorInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/registration", name="registration")
     */
    public function index(
        Request $request,
        UserPasswordEncoderInterface $userPasswordEncoder,
        GuardAuthenticatorHandler $guard,
        LoginFormAuthenticathorAuthenticator $login
    ): Response {
        
        $user = new User;

        $form = $this->createForm(UserType::class, $user)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($userPasswordEncoder->encodePassword($user, $form->get('plainPassword')->getData()));
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $guard->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $login,
                'main'
            );
        }

        return $this->render('registration/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
