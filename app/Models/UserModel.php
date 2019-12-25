<?php

namespace App\Models;

class UserModel extends \CodeIgniter\Model
{

    const EMAIL_RULES = 'max_length[255]|valid_email|min_length[2]';

    const PASSWORD_RULES = 'max_length[72]|min_length[5]';   

    protected $table = 'users';

    protected $returnType = User::class;

    protected $primaryKey = 'id';

    protected $createdField = 'created_at';

    protected $updatedField = 'updated_at';

    protected $dateFormat = 'datetime';

    protected $allowedFields = [
        'name',
        'password_hash',
        'email',
        'created_at',
        'updated_at',
        'email_verification_token',
        'password_reset_token',
        'email_verified_at'
    ];

    public function generateToken() : string
    {
        return md5(time() . rand(0, PHP_INT_MAX)) . '_' . time();
    }

    public function isTokenValid(string $token)
    {
        if (!$token)
        {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
     
        $expire = 600;
        
        return $timestamp + $expire >= time();
    }

    public function createEmailVerificationUrl(User $user)
    {
        return site_url('user/verifyEmail/' . $user->id  . '/'. $user->email_verification_token);
    }

    public function createResetPasswordUrl(User $user)
    {
        return site_url('user/resetPassword/' . $user->id . '/' .  $user->password_reset_token);
    }

    public function setPassword(User $user, string $password)
    {
        $user->password_hash = password_hash($password, PASSWORD_BCRYPT);
    }

    public function validatePassword(User $user, string $password) : bool
    {
        return password_verify($password, $user->password_hash);
    }

    public function findByEmail(string $email)
    {
        return $this->where(['email' => $email])->first();
    }

}