<?php

use App\Models\UserModel;

$userService = service('user');

if (!$userService->isGuest())
{
    $user = $userService->getUser();

    echo '<a href="' . site_url('user/logout') . '">Logout</a> (' . esc($user->name) . ')';
}
else
{
    echo '<a href="' . site_url('user/signup') . '">Signup</a>';
    echo ' | ';
    echo '<a href="' . site_url('user/login') . '">Login</a>';
    echo ' | ';
    echo '<a href="' . site_url('user/resendVerificationEmail') . '">Resend Verification Email</a>';
    echo ' | ';
    echo '<a href="' . site_url('user/requestPasswordReset') . '">Reset Password</a>';
}

echo ' | ';

echo '<a href="' . site_url('contact') . '">Contact Us</a>';