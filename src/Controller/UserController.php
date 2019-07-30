<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ThreadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    /**
     * @Route("/login", name="user.login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/logout", name="user.logout", methods={"GET"})
     */
    public function logout()
    {}

    /**
     * @Route("/user/{slug}", name="user.profile")
     * @param User $user
     * @param ThreadRepository $threadsRepo
     * @return Response
     */
    public function profile(User $user, ThreadRepository $threadsRepo)
    {
        $lastThreads = $threadsRepo->findBy(['author' => $user], ['date' => 'DESC'], 5);

        return $this->render('user/profile.html.twig', [
            'user' => $user,
            'lastThreads' => $lastThreads
        ]);
    }
}