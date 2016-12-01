<?php

// Registration
Breadcrumbs::register('account.register', function($breadcrumbs) {
    $breadcrumbs->push('Registration', route('account.register'));
});

// Home
Breadcrumbs::register('home', function($breadcrumbs) {
    $breadcrumbs->push('Home', route('base'));
});

// Login
Breadcrumbs::register('account.login', function($breadcrumbs) {
    $breadcrumbs->push('Login', route('account.login'));
});

// Profile
Breadcrumbs::register('account.profile', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Profile', route('account.profile'));
});