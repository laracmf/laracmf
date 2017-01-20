<?php

use App\Models\ThemeUser;
use GrahamCampbell\Credentials\Facades\Credentials;

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

function isRole($role)
{
    if (Credentials::getUser()) {
        return Credentials::inRole($role);
    }

    return false;
}

function commentOwner($userId)
{
    $user = Credentials::getUser();

    return $user && ($user->id === $userId);
}

function checkTheme()
{
    if (!session('theme') && $user = Credentials::getUser()) {
        $theme = ThemeUser::where('user_id', $user->id)->first();

        session(['theme' => $theme ? $theme->name : 'skin-blue']);
    }
}