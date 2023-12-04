<?php
namespace Config;

use CodeIgniter\Config\BaseService;

class Services extends BaseService
{
    public static function userViewComposer($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('userViewComposer');
        }

        return new \App\Controllers\UserViewComposer();
    }
}
