<?php

namespace Admin\Models;

use Exception;
use Admin\Config\Admin as AdminConfig;
use BasicApp\Auth\Interfaces\AuthModelInterface;

class AdminModel implements AuthModelInterface
{

    const USERNAME_RULES = 'max_length[255]|min_length[2]';

    const PASSWORD_RULES = 'max_length[72]|min_length[5]';

    public $primaryKey = 'username';

    public $returnType = 'array';    

    public function findAll(bool $refresh = false)
    {
        static $users;

        if ($refresh || ($users === null))
        {
            $config = config(AdminConfig::class);

            if (!$config)
            {
                throw new Exception(AdminConfig::class . ' not found.');
            }

            $users = [
                [
                    'username' => $config->username,
                    'password' => $config->password
                ]
            ];
        }

        return $users;
    }

    public function findByField($field, $value, bool $refresh = false)
    {
        foreach($this->findAll($refresh) as $id => $admin)
        {
            if ($admin[$field] == $value)
            {
                return $admin;
            }
        }

        return null;
    }

    public function findByUsername(string $username, bool $refresh = false)
    {
        return $this->findByField('username', $username, $refresh);
    }

    public function find($id = null, bool $refresh = false)
    {
        return $this->findByField('username', $id, $refresh);
    }

    public function encodePassword($user, string $password) : string
    {
        return $password;
    }

    public function validatePassword($user, string $password) : bool
    {
        return $password == $user['password'];
    }

}