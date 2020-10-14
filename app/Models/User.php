<?php

namespace App\Models;

use Config\Services;
use CodeIgniter\Email\Email;

class User extends \CodeIgniter\Entity
{

    public function composeEmail(string $view, array $params = [], array $options = []) : Email
    {
        $params['user'] = $this;

        $email = compose_email($view, $params, $options);

        $email->setTo($this->email, $this->name);

        return $email;
    }

    public function getResetPasswordUrl()
    {
        return site_url('user/resetPassword/' . $this->id . '/' .  $this->password_reset_token);
    }

    public function getEmailVerificationUrl()
    {
        return site_url('user/verifyEmail/' . $this->id  . '/'. $this->email_verification_token);
    }

    public function setPassword(string $password)
    {
        $this->password_hash = password_hash($password, PASSWORD_BCRYPT);
    }

    public function validatePassword(string $password) : bool
    {
        return password_verify($password, $this->password_hash);
    }

}