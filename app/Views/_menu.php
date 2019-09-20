<?php

use App\Models\UserModel;

$user = service('user');

if (!$user->isGuest())
{
    echo '<a href="' . site_url('user/logout') . '">Logout</a> (' . esc(UserModel::getUserName($user->getEntity())) . ')';
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