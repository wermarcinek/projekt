<?php
/**
 * App Kernel.
 */

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

/**
 * Class Kernel.
 *
 * Your class description goes here.
 *
 *  App
 */
class Kernel extends BaseKernel
{
    use MicroKernelTrait;
}
