<?php
#App\GP247\Plugins\CashPayment\Admin\AdminController.php

namespace App\GP247\Plugins\CashPayment\Admin;

use GP247\Core\Controllers\RootAdminController;
use App\GP247\Plugins\CashPayment\AppConfig;

class AdminController extends RootAdminController
{
    public $plugin;

    public function __construct()
    {
        parent::__construct();
        $this->plugin = new AppConfig;
    }
    public function index()
    {
        return view($this->plugin->appPath.'::Admin',
            [
                
            ]
        );
    }
}
