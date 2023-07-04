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
     *
     * @param UserRepository              $userRepository  User Repository
     * @param UserPasswordHasherInterface $passwordEncoder Password Hasher
     */
    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Save user.
     *
     * @param User        $user        User
     * @param string|null $newPassword new password
     *
     * @return void Void
     */
    public function changePassword(User $user, string $newPassword): void
    {
        if ($newPassword) {
            $encodedPassword = $this->passwordEncoder->hashPassword(
                $user,
                $newPassword
            );

            $user->setPassword($encodedPassword);
        }

        $this->userRepository->save($user);
    }
    /**
     * Change the email address for a user.
     *
     * @param User   $user     User entity
     * @param string $newEmail New email address
     *
     * @return void Void
     */
    public function changeEmail(User $user, string $newEmail): void
    {
        $user->setEmail($newEmail);

        $this->userRepository->save($user);
    }
}
