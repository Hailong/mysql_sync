# mysql_sync

A very lightweight but handy tool, which can diff the data between two databases, and sync the difference from "left" to "right".

## Configuration

Just provide the informaton of your "left" database, "right" database, and a list of tables you want to diff and sync. There is also a "dry run" flag to print out all the querie strings on screen, instead of carry out the real DB commands.

All configuration goes into `mysql_sync/Config/Config.php` file, as the example below:

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
            'database' => 'm2l_mig_s2',
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

`TABLE_NAMES` is the table list we want to diff and sync, which has the table name as a key, and an unique field of the table as value. **The tool uses this unique field to order and match the records between two tables.**

## Features

* "Left" database is regarded as the source, and "right" as the destination. That means any data in "left" but not in "right", or data shared the same "id" but different, would be synced up to "right".
* Set the limit of each query to 1000 records, so that to make sure it works large databases.

## Installation

Need to run `composer install` for the first time to build the autoloader.

## Run

Just run `run.php` in the root folder.
