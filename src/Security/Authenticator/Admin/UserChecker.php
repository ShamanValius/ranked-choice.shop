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

		if (!in_array('ROLE_ADMIN', $user->getRoles())) {
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
