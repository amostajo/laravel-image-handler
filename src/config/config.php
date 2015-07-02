<?php

/**
 * This file is part of Amostajo\LaravelImageHandler.
 *
 * @author Alejandro Mostajo
 * @license MIT
 * @package Amostajo\LaravelImageHandler
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Thumbs folder
    |--------------------------------------------------------------------------
    |
    | Thumbs folder located at the public folder within your project.
    |
    */
    'thumbs_folder' => '/thumbs/',

    /*
    |--------------------------------------------------------------------------
    | Default thumb's' width
    |--------------------------------------------------------------------------
    |
    | Default width for thumbs.
    |
    */
    'thumbs_width' => 100,

    /*
    |--------------------------------------------------------------------------
    | Default thumb's' height
    |--------------------------------------------------------------------------
    |
    | Default height for thumbs.
    |
    */
    'thumbs_height' => 100,

    /*
    |--------------------------------------------------------------------------
    | Cache minutes
    |--------------------------------------------------------------------------
    |
    | Amount of minutes to cache results.
    |
    */
    'cache_minutes' => 60,

    /*
    |--------------------------------------------------------------------------
    | Cache key format
    |--------------------------------------------------------------------------
    |
    | Resulting image urls are cached for fast loading.
    |
    | :filename = Filename.
    | :width    = Requested width.
    | :height   = Requested height.
    |
    */
    'cache_key_format' => ':filename_:widthx:height',
];