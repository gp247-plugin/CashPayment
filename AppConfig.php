<?php
/**
 * Plugin format 1.0
 */
#App\GP247\Plugins\CashPayment\AppConfig.php
namespace App\GP247\Plugins\CashPayment;

use App\GP247\Plugins\CashPayment\Models\ExtensionModel;
use GP247\Core\Models\AdminConfig;
use GP247\Core\Models\AdminHome;
use GP247\Core\Models\AdminMenu;
use GP247\Core\ExtensionConfigDefault;
use Illuminate\Support\Facades\DB;
class AppConfig extends ExtensionConfigDefault
{
    public function __construct()
    {
        //Read config from gp247.json
        $config = file_get_contents(__DIR__.'/gp247.json');
        $config = json_decode($config, true);
    	$this->configGroup = $config['configGroup'];
        $this->configKey = $config['configKey'];
        $this->configCode = $config['configCode'];
        $this->requireCore = $config['requireCore'] ?? [];
        $this->requireComposerPackages = $config['requireComposerPackages'] ?? [];
        $this->requireGp247Extensions = $config['requireGp247Extensions'] ?? [];
        //Path
        $this->appPath = $this->configGroup . '/' . $this->configKey;
        //Language
        $this->title = trans($this->appPath.'::lang.title');
        //Image logo or thumb
        $this->image = $this->appPath.'/'.$config['image'];
        //
        $this->version = $config['version'];
        $this->auth = $config['auth'];
        $this->link = $config['link'];
    }

    public function install()
    {
        $check = AdminConfig::where('key', $this->configKey)
            ->where('group', $this->configGroup)->first();
        if ($check) {
            //Check Plugin key exist
            $return = ['error' => 1, 'msg' =>  gp247_language_render('admin.extension.plugin_exist')];
        } else {
            //Insert plugin to config
            $dataInsert = [
                [
                    'group'  => $this->configGroup,
                    'key'    => $this->configKey,
                    'code'    => $this->configCode,
                    'sort'   => 0,
                    'store_id' => GP247_STORE_ID_GLOBAL,
                    'value'  => self::ON, //Enable extension
                    'detail' => $this->appPath.'::lang.title',
                ],
            ];
            try {
                AdminConfig::insert(
                    $dataInsert
                );

                $defaults = require __DIR__.'/config.php';
                AdminConfig::insert([
                    [
                        'group'    => $this->configKey,
                        'key'      => 'note',
                        'code'     => $this->configKey.'_config',
                        'sort'     => 1,
                        'store_id' => GP247_STORE_ID_GLOBAL,
                        'value'    => $defaults['note'] ?? '',
                        'detail'   => $this->appPath.'::lang.admin.note',
                    ],
                ]);

                (new ExtensionModel)->installExtension();


                $checkMenu = AdminMenu::where('key', 'ADMIN_SHOP_PAYMENT')->first();
                if ($checkMenu) { 
                    $position = $checkMenu->id;
                } else {
                    $checkContentMenu = AdminMenu::where('key','ADMIN_SHOP_ORDER')->first();
        
                    $checkMenu = AdminMenu::create([
                        'sort' => 30,
                        'parent_id' => $checkContentMenu->id ?? 0,
                        'title' => 'Payment',
                        'icon' => 'fas fa-mug-hot',
                        'key' => 'ADMIN_SHOP_PAYMENT',
                    ]);
                    $position = $checkMenu->id;
                }

                $payment = AdminMenu::where('key',$this->configKey)->first();
                if (!$payment) {
                    //
                }
        
                $return = ['error' => 0, 'msg' => gp247_language_render('admin.extension.install_success')];
            } catch (\Throwable $e) {
                $return = ['error' => 1, 'msg' => $e->getMessage()];
            }
        }

        return $return;
    }


    public function uninstall()
    {
        //Please delete all values inserted in the installation step
        try {
            (new AdminConfig)
            ->where('key', $this->configKey)
            ->orWhere('code', $this->configKey.'_config')
            ->orWhere('group', $this->configKey)
            ->delete();

            //Admin config home
            AdminHome::where('extension', $this->appPath)->delete();

            //
            AdminMenu::where('key',$this->configKey)
            ->delete();

            (new ExtensionModel)->uninstallExtension();

            $return = ['error' => 0, 'msg' => gp247_language_render('admin.extension.uninstall_success')];
        } catch (\Throwable $e) {
            $return = ['error' => 1, 'msg' => $e->getMessage()];
        }

        return $return;
    }
    
    public function enable()
    {
        $process = (new AdminConfig)
            ->where('group', $this->configGroup)
            ->where('key', $this->configKey)
            ->update(['value' => self::ON]);
        //Admin config home
        AdminHome::where('extension', $this->appPath)->update(['status' => 1]);

        if (!$process) {
            $return = ['error' => 1, 'msg' => gp247_language_render('admin.extension.action_error', ['action' => 'Enable'])];
        }
        $return = ['error' => 0, 'msg' => gp247_language_render('admin.extension.enable_success')];
        return $return;
    }

    public function disable()
    {
        $return = ['error' => 0, 'msg' => ''];
        $process = (new AdminConfig)
            ->where('group', $this->configGroup)
            ->where('key', $this->configKey)
            ->update(['value' => self::OFF]);
        if (!$process) {
            $return = ['error' => 1, 'msg' => 'Error disable'];
        }

        //Admin config home
        AdminHome::where('extension', $this->appPath)->update(['status' => 0]);

        return $return;
    }


    // Remove setup for store

    public function removeStore($storeId = null)
    {
        // code here
    }

    // Setup for store

    public function setupStore($storeId = null)
    {
       // code here
    }


    // Process when click button plugin in admin

    public function clickApp()
    {
        return redirect()->route('admin_cashpayment.index');
    }

    /**
     * Get info plugin
     *
     * @return  [type]  [return description]
     */
    /**
     * Resolve a setting for the effective store: the store's own row, falling back to the
     * GLOBAL row and finally the plugin's file default — the same two-tier store→GLOBAL
     * inheritance the platform uses, kept group-qualified (group = configKey) so the generic
     * key "note" never collides with another plugin's. On a single-store site the effective
     * store is ROOT ⇒ resolves to GLOBAL ⇒ behaviour unchanged.
     *
     * @param string $key Setting key (e.g. "note").
     * @return string The resolved value.
     *
     * @aidlc-unit plugin-cash-payment
     * @aidlc-story US-cash-payment-per-store-config
     * @aidlc-adr plugin-cash-payment_per-store-config
     */
    private function resolveSetting(string $key): string
    {
        $storeId = function_exists('gp247_plugin_store_id')
            ? gp247_plugin_store_id()
            : GP247_STORE_ID_GLOBAL;

        $value = AdminConfig::where('group', $this->configKey)
            ->where('key', $key)
            ->where('store_id', $storeId)
            ->value('value');

        if ($value === null && (string) $storeId !== (string) GP247_STORE_ID_GLOBAL) {
            $value = AdminConfig::where('group', $this->configKey)
                ->where('key', $key)
                ->where('store_id', GP247_STORE_ID_GLOBAL)
                ->value('value');
        }

        return (string) ($value ?? config($this->appPath.'.'.$key) ?? '');
    }

    public function getInfo()
    {
        // Per-store aware (storeScope=store): resolve the COD note for the effective store
        // (own row → GLOBAL → file default) instead of always reading GLOBAL.
        $note = $this->resolveSetting('note');

        $arrData = [
            'title' => $this->title,
            'key' => $this->configKey,
            'code' => $this->configCode,
            'image' => $this->image,
            'permission' => self::ALLOW,
            'version' => $this->version,
            'auth' => $this->auth,
            'link' => $this->link,
            'note' => $note,
            'appPath' => $this->appPath
        ];

        return $arrData;
    }
}
