<?php

namespace App\Models;

/**
 * Login form
 */
class LoginForm extends \App\Components\BaseModel
{

    protected static $_user;

    protected $validationRules = [
        'username' => 'trim|required|valid_email|max_length[255]|min_length[2]|App\Models\LoginForm::getUser',
        'password' => 'trim|required|max_length[72]|min_length[5]|App\Models\LoginForm::validatePassword',
        'rememberMe' => 'required|in_list[0,1]'
    ];

    protected $validationMessages = [
        'password' => [
            'App\Models\LoginForm::getUser' => 'User not found.',
            'App\Models\LoginForm::validatePassword' => 'Password Invalid.'
        ]
    ];

    protected $fieldLabels = [
        'username' => 'Username',
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
            $model = new UserModel;

            static::$_user = $model->where(['user_email' => $email])->first();

            if (static::$_user)
            {
                return true;
            }            

            return false;
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