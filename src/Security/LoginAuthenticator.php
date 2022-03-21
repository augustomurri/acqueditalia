<?php

namespace App\Security;

use App\Entity\Utenti;
use App\Repository\UtentiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use LasseRafn\InitialAvatarGenerator\InitialAvatar;

class LoginAuthenticator extends AbstractAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'login';

    private UrlGeneratorInterface $urlGenerator;
    private UtentiRepository $utentiRepository;
    private EntityManagerInterface $entityManager;
    private InitialAvatar $avatarGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator, UtentiRepository $utentiRepository, EntityManagerInterface $entityManager)
    {
        $this->avatarGenerator = new InitialAvatar();
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
        $this->utentiRepository = $utentiRepository;
    }

    public function supports(Request $request): ?bool
    {
        return $request->getPathInfo() === '/login' && $request->isMethod('POST');
    }

    public function authenticate(Request $request): Passport
    {
        $username = $request->request->get('_username', '');

        $request->getSession()->set(Security::LAST_USERNAME, $username);

        return new Passport(
            new UserBadge($username, function($userIdentifier) {
                $user = $this->utentiRepository->findOneBy(['email' => $userIdentifier]);

                if (!$user) {
                    throw new UserNotFoundException();
                }

                if (!$user->isVerified()) {
                    throw new CustomUserMessageAccountStatusException('non verificato');
                }

                return $user;
            }),
            new PasswordCredentials($request->request->get('_password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {

        $user = $token->getUser();

        $user->setUltimoLogin(new \DateTime());
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $session = $request->getSession();
        $avatar =  $this->avatarGenerator
                        ->name($user)
                        ->size(48)
                        ->background('#232e3e')
                        ->generate()
                        ->stream('data-url', 80);

        $session->set('avatar', (string)$avatar);

        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse(
            $this->urlGenerator->generate('home')
        );
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);

        return new RedirectResponse(
            $this->urlGenerator->generate(self::LOGIN_ROUTE)
        );

    }
}