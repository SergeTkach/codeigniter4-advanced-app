<?php

namespace Admin\Forms;

use Admin\Models\AdminModel;

/**
 * Login form
 */
class LoginForm extends \CodeIgniter\Model
{

    protected $returnType = 'array';

    protected $validationRules = [
        'username' => [
            'rules' => 'required|' . AdminModel::USERNAME_RULES,
            'label' => 'Login'
        ],
        'password' => [
            'rules' => 'required|' . AdminModel::PASSWORD_RULES . '|validAdmin[]',
            'label' => 'Password'
        ],
        'rememberMe' => [
            'rules' => 'required|in_list[0,1]',
            'label' => 'Remember Me'
        ]
    ];

}