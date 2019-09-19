<?php

namespace App\Models;

use Exception;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends \App\Components\BaseModel
{

    protected static $_user;

    protected $validationRules = [
        'email' => [
            'rules' => 'trim|required|valid_email|max_length[255]|' . __CLASS__ . '::validateEmail',
            'label' => 'Email'
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
            static::$_user = UserModel::findByEmail($email);

            return static::$_user ? true : false;
        }

        return true;
    }

    public function getUser()
    {
        return static::$_user;
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail(&$error = null)
    {    
        $user = $this->getUser();

        if (!UserModel::isTokenValid(UserModel::getUserField($user, 'password_reset_token')))
        {
            UserModel::setUserField($user, 'password_reset_token', UserModel::generateToken());

            $model = new UserModel;

            $model->protect(false);

            if (!$model->save($user))
            {
                throw new Exception('User not saved.');
            }

            $model->protect(true);
        }

        return service('mailer')->sendToUser(
            $user,
            'Password reset for ' . base_url(),
            view('messages/resetPassword', [
                'user' => $user,
                'resetLink' => UserModel::getUserResetPasswordUrl($user)
            ]),
            $error
        );
    }

}