<?php

namespace App\Models;

use App\Models\User;
use App\Models\UserModel;
use Config\Services;

/**
 * Signup form
 */
class SignupForm extends \App\Components\BaseModel
{

    protected $validationRules = [
        'username' => 'trim|required|max_length[255]|min_length[2]',
        'email' => 'trim|required|max_length[255]|valid_email|is_unique[user.user_email,user_id,{user_id}]',
        'password' => 'trim|required|max_length[72]|min_length[5]'
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'This email address has already been taken.'
        ]
    ];

    protected $fieldLabels = [
        'username' => 'Name',
        'email' => 'Email',
        'password' => 'Password'
    ];

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup(array $data, &$error = null)
    {
        $model = new UserModel;

        return $model->createUser([
            'user_name' => $data['username'],
            'user_email' => $data['email'],
            'user_password' => $data['password']
        ], $error);
    }

    /**
     * Sends confirmation email to user
     * @param User $user user data to with email should be send
     * @return bool whether the email was sent
     */
    public function sendEmail(User $user, &$error = null)
    {
        $model = new UserModel;

        $message = view('messages/signup', [
            'user' => $user,
            'verifyLink' => site_url('signup/verify-email/' . $user->user_verification_token)
        ]);

        return $model->sendEmail($user, 'Account registration at ' . base_url(), $message, $error);
    }

}