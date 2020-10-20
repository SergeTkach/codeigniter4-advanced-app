<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
if (!function_exists('adminAuth'))
{
    function adminAuth()
    {
        return service('adminAuth');
    }
}

if (!function_exists('admin_id'))
{
    function admin_id()
    {
        return adminAuth()->getUserId();
    }
}