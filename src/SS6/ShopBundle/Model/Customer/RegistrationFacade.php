<?php

namespace SS6\ShopBundle\Model\Customer;

use Doctrine\ORM\EntityManager;
use SS6\ShopBundle\Model\Customer\Mail\ResetPasswordMailFacade;
use SS6\ShopBundle\Model\Customer\UserRepository;

class RegistrationFacade {

	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	private $em;

	/**
	 * @var \SS6\ShopBundle\Model\Customer\UserRepository
	 */
	private $userRepository;

	/**
	 * @var \SS6\ShopBundle\Model\Customer\Mail\ResetPasswordMailFacade
	 */
	private $resetPasswordMailFacade;

	/**
	 * @var \SS6\ShopBundle\Model\Customer\RegistrationService
	 */
	private $registrationService;

	public function __construct(
		EntityManager $em,
		UserRepository $userRepository,
		RegistrationService $registrationService,
		ResetPasswordMailFacade $resetPasswordMailFacade
	) {
		$this->em = $em;
		$this->userRepository = $userRepository;
		$this->registrationService = $registrationService;
		$this->resetPasswordMailFacade = $resetPasswordMailFacade;
	}

	/**
	 * @param string $email
	 * @param int $domainId
	 */
	public function resetPassword($email, $domainId) {
		$user = $this->userRepository->getUserByEmailAndDomain($email, $domainId);

		$this->registrationService->resetPassword($user);
		$this->resetPasswordMailFacade->sendMail($user);
	}

	/**
	 * @param string $email
	 * @param int $domainId
	 * @param string $hash
	 */
	public function isResetPasswordHashValid($email, $domainId, $hash) {
		$user = $this->userRepository->getUserByEmailAndDomain($email, $domainId);

		return $this->registrationService->isResetPasswordHashValid($user, $hash);
	}

	/**
	 * @param string $email
	 * @param int $domainId
	 * @param string $hash
	 * @param string $newPassword
	 * @return \SS6\ShopBundle\Model\Customer\User
	 */
	public function setNewPassword($email, $domainId, $hash, $newPassword) {
		$user = $this->userRepository->getUserByEmailAndDomain($email, $domainId);

		$this->registrationService->setNewPassword($user, $hash, $newPassword);

		return $user;
	}

}
