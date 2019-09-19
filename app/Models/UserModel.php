<?php

namespace App\Models;

class UserModel extends \denis303\user\BaseUserModel
{

    const EMAIL_RULES = 'max_length[255]|valid_email|min_length[2]';

    const PASSWORD_RULES = 'max_length[72]|min_length[5]';   

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
        $token = static::getUserField($user, 'verification_token');

        if (!$token)
        {
            static::setUserField($user, 'verification_token', static::generateToken());
        }
    }

    public static function generateToken()
    {
        return md5(time() . rand(0, PHP_INT_MAX)) . '_' . time();
    }

    public static function getUserVerificationUrl($user)
    {
        $id = static::getUserField($user, 'id');

        $token = static::getUserField($user, 'verification_token');

        return site_url('user/verifyEmail/' . $id  . '/'. $token);
    }

    public static function getUserResetPasswordUrl($user)
    {
        $id = static::getUserField($user, 'id');
        
        $token = static::getUserField($user, 'password_reset_token');

        return site_url('user/resetPassword/' . $id . '/' .  $token);
    }

    /**
     * Finds out if token is valid
     *
     * @param string $token token
     * @return bool
     */
    public static function isTokenValid($token)
    {
        if (!$token)
        {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
     
        $expire = 600;
        
        return $timestamp + $expire >= time();
    }

}