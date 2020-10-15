<?php

namespace App\Libraries;

use App\Models\UserModel;
use App\Models\User;

class AuthService extends \BasicApp\Auth\BaseAuthService
{

    protected $_user;

    public function getUserId() : ?int
    {
        return parent::getUserId();
    }

    public function login($user, $rememberMe = true)
    {
        if ($user instanceof User)
        {
            $user = $user->id;
        }

        return parent::login($user, $rememberMe);
    }

    public function getUser() : ?User
    {
        if (!$this->_user)
        {
            $id = $this->getUserId();

            if ($id)
            {
                $this->_user = (new UserModel)->find($id);

                if (!$this->_user)
                {
                    $this->logout();
                }
            }
        }

        return $this->_user;
    }

}