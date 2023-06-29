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
     * change password function.
     */
    public function changePassword(User $user, string $newPassword): void;

    /**
     * change email function.
     */
    public function changeEmail(User $user, string $newEmail): void;
}
