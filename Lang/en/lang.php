<?php
return [
    'title'      => 'Cash payment',
    'admin'      => [
        'title'          => 'Cash payment',
        'note'           => 'Note shown to customer at checkout',
    ],

    // Check before use (readiness)
    'ready_payment_off' => 'The payment step is off: shoppers do not see cash payment at checkout.',
    'ready_payment_on'  => 'The payment step is on at checkout.',
    'fix_order_tab'     => 'Shop configuration → Order',
    'ready_plugin_off'  => 'Cash payment is not enabled for this store: shoppers do not see it at checkout.',
    'ready_plugin_on'   => 'Cash payment is enabled for this store.',
    'fix_plugins'       => 'Extension → Plugins',
];
