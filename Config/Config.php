<?php

namespace MySqlSync\Config;

/**
 * Config
 */
class Config
{
    const LEFT_DATABASE = [
        'host' => 'localhost',
        'username' => 'root',
        'password' => 'password1',
        'database' => 'm2_new',
    ];

    const RIGHT_DATABASE = [
        'host' => 'localhost',
        'username' => 'root',
        'password' => 'password1',
        'database' => 'm2l_mig_s1',
    ];

    const TABLE_NAMES = [
        'sales_order_tax' => 'tax_id',
        'sales_flat_order' => 'entity_id',
    ];

    const DRY_RUN = TRUE;
}
