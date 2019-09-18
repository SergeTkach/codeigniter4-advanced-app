<?php

namespace App\Models;

class UserModel extends \denis303\user\BaseUserModel
{

    const STATUS_DELETED = 1;

    const STATUS_INACTIVE = 9;

    const STATUS_ACTIVE = 10;

    protected $defaultStatus = self::STATUS_INACTIVE;

    public function setStatusActive(User $user)
    {
        $this->setStatus(static::STATUS_ACTIVE);
    }

    public function setStatusInactive(User $user)
    {
        $this->setStatus(static::STATUS_INACTIVE);
    }    

    public function setStatusDeleted(User $user)
    {
        $this->setStatus(static::STATUS_INACTIVE);
    }     

}