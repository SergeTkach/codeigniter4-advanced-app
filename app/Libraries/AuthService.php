<?php

namespace App\Libraries;

use App\Models\UserModel;
use App\Models\User;

class AuthService extends \Denis303\Auth\UserService
{

    protected $_user;

    public function login(User $user, bool $rememberMe = true, & $error = null)
    {
        if (!$user->id)
        {
            $error = lang('user', 'Primary key not defined.');

            return false;
        }

        $this->setUserId($user->id, $rememberMe);
    
        $this->_user = $user;

        return true;
    }

    public function getUser()
    {
        if (!$this->_user)
        {
            $id = (int) $this->getUserId();

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

    public function logout()
    {
        $this->_user = null;

        $this->deleteUserId();
    }

    public function isGuest() : bool
    {
        return $this->getUser() ? false : true;
    }

    public function isLogged()
    {
        return !$this->isGuest();
    }

}