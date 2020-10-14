<?php

namespace App\Forms;

use App\Models\UserModel;

/**
 * Login form
 */
class LoginForm extends \CodeIgniter\Model
{

    protected $returnType = 'array';

    protected static $_user;

    protected $validationRules = [
        'email' => [
            'rules' => 'required|' . UserModel::EMAIL_RULES. '|' . __CLASS__ .'::validateEmail|' . __CLASS__ .'::validateEmailVerification',
            'label' => 'Email'
        ],
        'password' => [
            'rules' => 'required|' . UserModel::PASSWORD_RULES . '|' . __CLASS__ .'::validatePassword',
            'label' => 'Password'
        ],
        'rememberMe' => [
            'rules' => 'required|in_list[0,1]',
            'label' => 'Remember Me'
        ]
    ];

    protected $validationMessages = [
        'email' => [
            __CLASS__ . '::validateEmail' => 'There is no user with this email address.',
            __CLASS__ . '::validateEmailVerification' => 'Email is not verified.',
        ],
        'password' => [
            __CLASS__ . '::validatePassword' => 'Password Invalid.'
        ]
    ];

    /**
     * Finds user by [[user_email]]
     *
     * @return User|bool|null
     */
    public function getUser()
    {
        return static::$_user;
    }

    public static function validateEmail($email)
    {
        $model = new UserModel;

        static::$_user = $model->findByEmail($email);

        return static::$_user ? true : false;
    }

    public static function validateEmailVerification($email)
    {
        if (static::$_user)
        {
            if (!static::$_user->email_verified_at)
            {
                static::$_user = null;

                return false;
            }
        }

        return true;
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $password the attribute currently being validated
     */
    public static function validatePassword(string $password)
    {
        if (static::$_user)
        {
            return static::$_user->validatePassword($password);
        }

        return true;
    }

}