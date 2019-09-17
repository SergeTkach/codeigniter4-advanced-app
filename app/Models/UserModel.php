<?php

namespace App\Models;

use Exception;
use Config\Services;

class UserModel extends \App\Components\BaseModel
{

    const STATUS_INACTIVE = 9;

    const STATUS_ACTIVE = 10;

    protected $table = 'user';

    protected $primaryKey = 'user_id';

    protected $allowedFields = [
        'user_name',
        'user_password_hash',
        'user_password_reset_token',
        'user_verification_token',
        'user_email',
        'user_created_at',
        'user_updated_at'
    ];

    protected $returnType = User::class;

    public function createUser(array $data, & $error = null)
    {
        $user = new User;

        if (array_key_exists('user_password', $data))
        {
            $this->setPassword($user, $data['user_password']);

            unset($data['user_password']);
        }

        foreach($data as $key => $value)
        {
            $user->$key = $value;
        }

        if (!$user->user_verification_token)
        {
            $this->generateEmailVerificationToken($user);
        }

        if (!$this->save($user))
        {
            $error = $this->firstError();

            return false;
        }

        return $user;
    }

    public function setPassword(User $user, string $password)
    {
        $user->user_password_hash = password_hash($password, PASSWORD_BCRYPT);
    }

    public function generateEmailVerificationToken(User $user)
    {
        $user->user_verification_token = md5(time() . rand(0, PHP_INT_MAX));
    }

    public function sendEmail(User $user, string $subject, string $message, & $error = null)
    {
        $email = Services::email();

        if (!$email->fromEmail)
        {
            throw new Exception('Undefined property: ' . get_class($email) . '::$fromEmail');
        }        

        $email->initialize(['mailType' => 'html']);
        
        $email->setTo($user->user_email);

        $email->setSubject($subject);

        $email->setMessage($message);

        $return = $email->send();

        if (!$return)
        {
            if (CI_DEBUG)
            {
                $error = $email->printDebugger([]); 
            }
            else
            {
                $error = 'There was an error sending your message.';
            }
        }

        return $return;
    }

    public function validatePassword(User $user, string $password) : bool
    {
        return password_verify($password, $user->user_password_hash);
    }

}