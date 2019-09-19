<?php

namespace App\Models;

/**
 * Login form
 */
class LoginForm extends \App\Components\BaseModel
{

    protected static $_user;

    protected $validationRules = [
        'email' => 'trim|required|valid_email|max_length[255]|min_length[2]|' . __CLASS__ .'::getUser',
        'password' => 'trim|required|max_length[72]|min_length[5]|' . __CLASS__ .'::validatePassword',
        'rememberMe' => 'required|in_list[0,1]'
    ];

    protected $validationMessages = [
        'email' => [
            __CLASS__ . '::getUser' => 'There is no user with this email address.',
        ],
        'password' => [
            __CLASS__ . '::validatePassword' => 'Password Invalid.'
        ]
    ];

    protected $fieldLabels = [
        'email' => 'Email',
        'password' => 'Password',
        'rememberMe' => 'Remember Me'
    ];

    /**
     * Finds user by [[user_email]]
     *
     * @return User|bool|null
     */
    public static function getUser($email = null)
    {
        if ($email !== null)
        {
            static::$_user = UserModel::findByEmail($email);

            return static::$_user ? true : false;
        }

        return static::$_user;
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $password the attribute currently being validated
     */
    public static function validatePassword(string $password) : bool
    {
        $user = static::getUser();

        if ($user)
        {
            $model = new UserModel;

            return $model->validatePassword($user, $password);
        }

        return true;
    }

}