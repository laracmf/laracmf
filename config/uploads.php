<?php

/*
 * This file is part of Bootstrap CMS.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Upload dir
    |--------------------------------------------------------------------------
    */

    'upload_dir' => 'uploads/',

    /*
    |--------------------------------------------------------------------------
    | Upload size limit
    |--------------------------------------------------------------------------
    */

    'size_limit' => env('UPLOAD_SIZE_LIMIT', 10000000),

    /*
    |--------------------------------------------------------------------------
    | Upload allowed types
    |--------------------------------------------------------------------------
    */

    'allowed_types' => env(
        'UPLOAD_ALLOWED_TYPES',
        [
            'image/jpeg',
            'image/png',
            'image/gif',
            'application/x-php',
            'video/mp4'
        ]
    ),

    /*
    |--------------------------------------------------------------------------
    | Upload allowed types
    |--------------------------------------------------------------------------
    */

    'images_types' => [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_ICO],

];
