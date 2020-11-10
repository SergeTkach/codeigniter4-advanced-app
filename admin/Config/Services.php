<?php

namespace Admin\Config;

use Exception;
use CodeIgniter\Config\Services as CoreServices;
use BasicApp\Auth\Libraries\AuthService;
use BasicApp\SuperAdmin\Models\SuperAdminModel;

class Services extends CoreServices
{

    public static function adminAuth($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance(__FUNCTION__);
        }

        return new AuthService(SuperAdminModel::class, 'adminId');
    }

}