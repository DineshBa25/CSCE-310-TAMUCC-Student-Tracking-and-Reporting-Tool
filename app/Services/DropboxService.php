<?php
// app/Services/DropboxService.php

namespace App\Services;

use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;

class DropboxService
{
    public static function getDropboxClient()
    {
        $app = new DropboxApp(
            getenv('dropBoxClientID'),
            getenv('dropBoxClientSecret'),
            getenv('dropBoxToken')
        );

        return new Dropbox($app);
    }
}
