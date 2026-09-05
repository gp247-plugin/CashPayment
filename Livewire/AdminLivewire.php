<?php
#App\GP247\Plugins\CashPayment\Livewire\AdminLivewire.php

namespace App\GP247\Plugins\CashPayment\Livewire;

use GP247\Core\AdminShell\Infrastructure\ConfigForm;
use GP247\Core\Models\AdminConfig;

/**
 * Admin settings screen for the Cash payment plugin (checkout note shown to
 * the customer), backed by the admin_config key/value table.
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
}
