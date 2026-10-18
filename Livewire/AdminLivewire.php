<?php
#App\GP247\Plugins\CashPayment\Livewire\AdminLivewire.php

namespace App\GP247\Plugins\CashPayment\Livewire;

use GP247\Core\AdminShell\Infrastructure\ConfigForm;
use GP247\Core\AdminShell\Infrastructure\ReadinessCheck;
use GP247\Core\Models\AdminConfig;
use GP247\Shop\Payment\PaymentSettings;

/**
 * Admin settings screen for the Cash payment plugin (checkout note shown to
 * the customer), backed by the admin_config key/value table. Above the form, "Check
 * before use" lists what still hides the method at checkout (readiness()).
 *
 * @aidlc-unit plugin-cash-payment
 * @aidlc-story US-cash-payment-per-store-config
 * @aidlc-story US-cash-payment-config-readiness
 */
class AdminLivewire extends ConfigForm
{
    protected ?string $permission = null;

    /**
     * Seed default rows for installs made before this settings screen existed,
     * so the form is never empty for an already-installed plugin.
     */
    public function mount(): void
    {
        $defaults = require __DIR__.'/../config.php';
        foreach ($defaults as $key => $value) {
            AdminConfig::firstOrCreate(
                ['group' => $this->group(), 'key' => $key, 'store_id' => $this->storeId()],
                ['code' => $this->group().'_config', 'sort' => 0, 'value' => $value, 'detail' => 'Plugins/CashPayment::lang.admin.'.$key]
            );
        }

        parent::mount();
    }

    /**
     * Opt into per-store scope: on a multi-store/marketplace site the screen shows the
     * store picker so each store keeps its own COD note, inheriting the shared value until
     * overridden. The plugin's on/off per store is handled centrally on the "Manage Plugin"
     * list (US-PLG-per-store-plugin-enable-list), so no enableKey() here. Single-store: no-op.
     *
     * @return bool
     *
     * @aidlc-unit plugin-cash-payment
     * @aidlc-story US-cash-payment-per-store-config
     * @aidlc-adr plugin-cash-payment_per-store-config
     */
    protected function storeScoped(): bool
    {
        return true;
    }

    protected function group(): string
    {
        return 'CashPayment';
    }

    protected function heading(): string
    {
        return trans('Plugins/CashPayment::lang.title');
    }

    protected function keys(): array
    {
        return ['note'];
    }

    protected function fieldTypes(): array
    {
        return [
            'note' => 'text',
        ];
    }

    /**
     * What still hides cash on delivery at checkout: the payment step turned off in the
     * shop, or this plugin off for the store. The note is optional, so it is not listed.
     *
     * @return array<int, ReadinessCheck>
     *
     * @aidlc-unit plugin-cash-payment
     * @aidlc-story US-cash-payment-config-readiness
     * @aidlc-story US-admin-shell-config-form-readiness
     */
    protected function readiness(): array
    {
        $store = $this->readinessStoreId();
        $t = static fn (string $key): string => (string) trans('Plugins/CashPayment::lang.' . $key);

        return $this->shopChecks($store, $t);
    }

    /**
     * The shop-side conditions — the payment step at checkout and this plugin on for the
     * store — from gp247/shop, so every payment plugin shows the same thing. An older
     * gp247/shop without PaymentSettings::readiness() gets the same two checks computed here.
     *
     * @param string   $store Store being checked.
     * @param \Closure $t     Translator of this plugin's strings.
     * @return array<int, ReadinessCheck> payment_enabled, provider_enabled.
     *
     * @aidlc-story US-payment-request-plugin-readiness-check
     */
    private function shopChecks(string $store, \Closure $t): array
    {
        if (method_exists(PaymentSettings::class, 'readiness')) {
            return PaymentSettings::readiness($store, 'CashPayment');
        }

        return [
            ReadinessCheck::failIf(in_array($this->saved('use_payment', $store), ['', '0'], true), 'payment_enabled', $t('ready_payment_off'),
                ReadinessCheck::ERROR, self::adminUrl('admin_config.index'), $t('fix_order_tab'), $t('ready_payment_on')),
            ReadinessCheck::failIf($this->saved('CashPayment', $store, 'Plugins') !== '1', 'provider_enabled', $t('ready_plugin_off'),
                ReadinessCheck::ERROR, self::adminUrl('admin_plugin.index'), $t('fix_plugins'), $t('ready_plugin_on')),
        ];
    }

    /**
     * A setting read straight from admin_config: the store row, else the GLOBAL row.
     *
     * WHY not gp247_config(): it caches the rows for the whole request, so right after a
     * save the box would still show the values from before it.
     *
     * @param string      $key   admin_config key.
     * @param string      $store Store id.
     * @param string|null $group admin_config group (null = any).
     * @return string Trimmed value, '' when unset.
     */
    private function saved(string $key, string $store, ?string $group = null): string
    {
        $global = (string) (defined('GP247_STORE_ID_GLOBAL') ? GP247_STORE_ID_GLOBAL : 0);
        foreach (array_unique([$store, $global]) as $scope) {
            $row = AdminConfig::where('key', $key)->where('store_id', $scope)
                ->when($group !== null, static fn ($q) => $q->where('group', $group))->first();
            if ($row !== null && trim((string) $row->value) !== '') {
                return trim((string) $row->value);
            }
        }

        return '';
    }

    /**
     * @param string $route Admin route name.
     * @return string URL, or '' when the route is not registered.
     */
    private static function adminUrl(string $route): string
    {
        return \Illuminate\Support\Facades\Route::has($route) ? (string) gp247_route_admin($route) : '';
    }
}
