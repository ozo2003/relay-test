<?php declare(strict_types = 1);

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Contracts\Translation\TranslatorInterface;

final class SecurityController extends AbstractController
{
    public function __construct(
        private readonly Security $security,
    ) {
    }

    #[Route('/api/users/login', name: 'api_users_login', methods: [Request::METHOD_POST, ])]
    public function login(#[CurrentUser] ?User $user): Response
    {
        if (!$user->getIsActive()) {
            $this->security->logout(false);
            throw new AccessDeniedHttpException('');
        }

        if (null !== $user->getBlockedAt()) {
            $this->security->logout(false);
            throw new AccessDeniedHttpException('');
        }

        return new Response(status: Response::HTTP_NO_CONTENT);
    }

    #[Route('/api/users/logout', name: 'api_users_logout', methods: [Request::METHOD_GET, ])]
    public function logout(#[CurrentUser] ?User $user): Response
    {
        if (null !== $user) {
            $this->security->logout(false);
        }

        return new Response(status: Response::HTTP_NO_CONTENT);
    }
}
