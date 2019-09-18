<?php

namespace App\Models;

class UserModel extends \denis303\user\BaseUserModel
{   

    protected $returnType = User::class;

    protected $allowedFields = [
        self::FIELD_PREFIX . 'name',
        self::FIELD_PREFIX . 'password_hash',
        self::FIELD_PREFIX . 'email',
        self::FIELD_PREFIX . 'created_at',
        self::FIELD_PREFIX . 'updated_at',
        self::FIELD_PREFIX . 'verification_token',
        self::FIELD_PREFIX . 'password_reset_token',
        self::FIELD_PREFIX . 'verified_at'
    ];

    public function beforeCreateUser($user, array $data)
    {
        if (!$user->user_verification_token)
        {
            $this->generateEmailVerificationToken($user);
        }        
    }

    public function generateEmailVerificationToken(User $user)
    {
        $user->{static::FIELD_PREFIX . 'verification_token'} = md5(time() . rand(0, PHP_INT_MAX));
    }

    public function generatePasswordResetToken(User $user)
    {
        $user->{static::FIELD_PREFIX . 'password_reset_token'} = md5(time() . rand(0, PHP_INT_MAX));
    }

}