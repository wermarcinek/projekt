<?php
/**
 * User data Service Interface.
 */

namespace App\Service;

use App\Entity\User;

/**
 * Interface UserDataServiceInterface.
 */
interface UserDataServiceInterface
{
    /**
     * Change the password for a user.
     *
     * @param User   $user        the user entity
     * @param string $newPassword the new password
     */
    public function changePassword(User $user, string $newPassword): void;

    /**
     * Change the email for a user.
     *
     * @param User   $user     the user entity
     * @param string $newEmail the new email address
     */
    public function changeEmail(User $user, string $newEmail): void;
}
