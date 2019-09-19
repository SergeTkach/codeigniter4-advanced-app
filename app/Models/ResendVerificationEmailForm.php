<?php

namespace App\Models;

use Exception;

class ResendVerificationEmailForm extends \App\Components\BaseModel
{

    protected static $_user;

    protected $validationRules = [
        'email' => [
            'label' => 'Email',
            'rules' => 'trim|valid_email|required|max_length[255]|' . __CLASS__ . '::validateEmail'
        ]
    ];

    protected $validationMessages = [
        'email' => [
            __CLASS__ . '::validateEmail' => 'There is no user with this email address.'
        ]
    ];

    public static function validateEmail($email)
    {
        if ($email)
        {
            $user = UserModel::findByEmail($email);

            if (!$user)
            {
                return false;
            }

            if (UserModel::getUserField($user, 'verified_at'))
            {
                $error = 'Sorry, we are unable to resend verification email for the provided email address.';

                $this->validationMessages['email'][__CLASS__ . '::validateEmail'] = $error;

                return false;
            }

            static::$_user = $user;
        }

        return true;
    }

    public function getUser()
    {
        return static::$_user;
    }

    public function sendEmail(&$error)
    {
        $user = $this->getUser();

        if (!UserModel::isTokenValid(UserModel::getUserField($user, 'verification_token')))
        {
            UserModel::setUserField($user, 'verification_token', UserModel::generateToken());

            $model = new UserModel;

            $model->protect(false);

            if(!$model->save($user))
            {
                throw new Exception('User not saved.');
            }

            $model->protect(true);
        }

        return service('mailer')->sendToUser(
            $user, 
           'Account verification at ' . base_url(), 
            view('messages/verification', [
                'user' => $user,
                'verifyLink' => UserModel::getUserVerificationUrl($user)
            ]), 
            $error
        );
    }

}