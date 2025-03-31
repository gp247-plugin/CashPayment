<?php
#App\GP247\Plugins\CashPayment\Models\ExtensionModel.php
namespace App\GP247\Plugins\CashPayment\Models;

class ExtensionModel
{
    public $configGroup;
    public $configKey;
    public $requireCore;
    public $appPath;
    public function __construct()
    {
        //Read config from gp247.json
        $config = file_get_contents(__DIR__.'/../gp247.json');
        $config = json_decode($config, true);
    	$this->configGroup = $config['configGroup'];
        $this->configKey = $config['configKey'];
        $this->requireCore = $config['requireCore'];
        $this->appPath = $this->configGroup . '/' . $this->configKey;
    }

    public function uninstallExtension()
    {
        //
    }

    public function installExtension()
    {
        //
    }
    
}
