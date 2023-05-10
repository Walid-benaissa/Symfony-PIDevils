<?php

namespace App\Service;

use App\Entity\User;
use Proxies\__CG__\App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\FormLoginAuthenticator;

class LoginService
{
    private UserCheckerInterface $checker;
    private UserAuthenticatorInterface $userAuthenticator;
    private FormLoginAuthenticator $formLoginAuthenticator;

    /**
     * @param UserCheckerInterface $checker
     * @param UserAuthenticatorInterface $userAuthenticator
     * @param FormLoginAuthenticator $formLoginAuthenticator
     */
    public function __construct(UserCheckerInterface $checker, UserAuthenticatorInterface $userAuthenticator, FormLoginAuthenticator $formLoginAuthenticator)
    {
        $this->checker = $checker;
        $this->userAuthenticator = $userAuthenticator;
        $this->formLoginAuthenticator = $formLoginAuthenticator;
    }


    public function login(Utilisateur $user, Request $request): void
    {
        $this->checker->checkPreAuth($user);
        $this->userAuthenticator->authenticateUser($user, $this->formLoginAuthenticator, $request);
    }
}
