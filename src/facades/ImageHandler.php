<?php

namespace Amostajo\LaravelImageHandler\Facades;

/**
 * Facade for package.
 *
 * @author Alejandro Mostajo
 * @license MIT
 * @package Amostajo\LaravelImageHandler
 */

use Illuminate\Support\Facades\Facade;

class ImageHandler extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'imageHandler';
    }
}
