<?php

namespace App\Validation;

use App\Models\UserModel;
use App\Models\User;

class UserRules
{

    protected function getUser(array $data, &$error = null) : ?User
    {
        $user = model('UserModel')->findByEmail($data['email']);

        if ($user && $user->validatePassword($data['password']))
        {
            return $user;
        }

        $error = lang('User not found or password incorrect.');

        return false;
    }

    protected function validateVerification(User $user, &$error = null)
    {
        if (!$user->email_verified_at)
        {
            $error = lang('Email is not verified.');

            return false;
        }

        return true;
    }

    public function verifiedUser($email, $reserved, array $data, &$error = null) : bool
    {
        if (empty($data['password']) || empty($data['email']))
        {
            return true;
        }

        if (!$user = $this->getUser($data, $error))
        {
            return false;
        }

        if (!$this->validateVerification($user, $error))
        {
            return false;
        }

        return true;
    }

    public function validUser($email, $reserved, array $data, &$error = null) : bool
    {
        if (empty($data['password']) || empty($data['email']))
        {
            return true;
        }

        return $this->getUser($data, $error) ? true : false;
    }

}