<?php

namespace App\Models;

use Config\Services;

class User extends \CodeIgniter\Entity
{

    public function sendMessage(string $view, array $params = [], & $error = null, array $options = [])
    {
        $params['user'] = $this;

        $email = compose_email($view, $params, $options);

        $email->setTo($this->email, $this->name);

        return send_email($email, $error);
    }

}