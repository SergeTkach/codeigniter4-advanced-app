<?php

namespace Admin\Forms;

use BasicApp\SuperAdmin\Models\SuperAdminModel;

/**
 * Login form
 */
class LoginForm extends \CodeIgniter\Model
{

    protected $returnType = 'array';

    protected $validationRules = [
        'username' => [
            'rules' => 'required|' . SuperAdminModel::USERNAME_RULES,
            'label' => 'Login'
        ],
        'password' => [
            'rules' => 'required|' . SuperAdminModel::PASSWORD_RULES . '|validAdmin[]',
            'label' => 'Password'
        ],
        'rememberMe' => [
            'rules' => 'required|in_list[0,1]',
            'label' => 'Remember Me'
        ]
    ];

}