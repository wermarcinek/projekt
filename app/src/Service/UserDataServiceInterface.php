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
     * @param User   $user        The user entity.
     * @param string $newPassword The new password.
     *
     * @return void
     */
    public function changePassword(User $user, string $newPassword): void;

    /**
     * Change the email for a user.
     *
     * @param User   $user     The user entity.
     * @param string $newEmail The new email address.
     *
     * @return void
     */
    public function changeEmail(User $user, string $newEmail): void;
}
