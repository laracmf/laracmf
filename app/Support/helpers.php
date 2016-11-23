<?php

function isImage($path)
{
    return in_array(exif_imagetype($path), config('uploads.images_types'));
}

function formatBytes($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' kB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }

    return $bytes;
}

function userPermissions(GrahamCampbell\Credentials\Credentials $credentials, $level)
{
    $role = $credentials->findRoleBySlug($level);

    if ($role) {
        $permissions = array_filter(
            $role->permissions,
            function ($value) {
                return $value;
            }
        );

        return array_keys($permissions);
    }

    return false;
}

function isRole($role)
{
    if (\GrahamCampbell\Credentials\Facades\Credentials::getUser()) {
        return \GrahamCampbell\Credentials\Facades\Credentials::inRole($role);
    }

    return true;
}
