<?php

// Home
Breadcrumbs::register('home', function($breadcrumbs) {
    $breadcrumbs->push('Home', route('base'));
});

// Profile
Breadcrumbs::register('account.profile', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Profile', route('account.profile'));
});