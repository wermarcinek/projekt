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
     * Save user.
     *
     * @param User        $user             User
     * @param string|null $newPlainPassword New plain password
     *
     * @return mixed Void
     */
    public function save(User $user, string $newPlainPassword = null);
}
