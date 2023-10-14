<?php

namespace App\Security\Authenticator\Admin;

use App\Entity\User as AppUser;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
	public function checkPreAuth(UserInterface $user): void
	{
		if (!$user instanceof AppUser) {
			return;
		}

        // TODO This check does not take into account the hierarchy of roles
		if (!in_array('ROLE_ADMIN', $user->getRoles())
                && !in_array('ROLE_SUPER_ADMIN', $user->getRoles())) {
			throw new CustomUserMessageAccountStatusException('Your user account is not an administrator!');
		}
	}

	public function checkPostAuth(UserInterface $user): void
	{
		if (!$user instanceof AppUser) {
			return;
		}
	}
}
