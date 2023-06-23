<?php
/**
 * User data Service.
 */

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Class UserService.
 */
class UserDataService implements UserDataServiceInterface
{
    /**
     * User repository.
     */
    private UserRepository $userRepository;

    /**
     * Hasher.
     */
    private UserPasswordHasherInterface $passwordEncoder;

    /**
     * Constructor.
     */
    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Save user.
     */
    public function save(User $user, ?string $newPlainPassword = null)
    {
        if ($newPlainPassword) {
            $encodedPassword = $this->passwordEncoder->hashPassword(
                $user,
                $newPlainPassword
            );

            $user->setPassword($encodedPassword);
        }

        $this->userRepository->save($user);
    }
}
