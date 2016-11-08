<?php

/*
 * This file is part of Bootstrap CMS.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\BootstrapCMS\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * This is the comment model class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class Media extends Model
{
    protected $fillable = ['name', 'path', 'type', 'size'];
}
