<?php

require 'vendor/autoload.php';

use MySqlSync\Config\Config;
use MySqlSync\Model\DB;

$leftDB = new DB(
    Config::LEFT_DATABASE['host'],
    Config::LEFT_DATABASE['username'],
    Config::LEFT_DATABASE['password'],
    Config::LEFT_DATABASE['database']
);

$rightDB = new DB(
    Config::RIGHT_DATABASE['host'],
    Config::RIGHT_DATABASE['username'],
    Config::RIGHT_DATABASE['password'],
    Config::RIGHT_DATABASE['database']
);

foreach (Config::TABLE_NAMES as $table => $key) {

    $leftTable = $leftDB->openTable($table, $key);
    $rightTable = $rightDB->openTable($table, $key);

    $leftRow = $leftTable->fetchRow();
    $rightRow = $rightTable->fetchRow();

    while ($leftRow || $rightRow) {
        if (!$leftRow) {
            // No more records to merge
            break;
        }

        if (!$rightRow) {
            $rightDB->insert($table, $key, $leftRow);
            $leftRow = $leftTable->fetchRow();
            continue;
        }

        if ($leftRow[$key] == $rightRow[$key]) {
            if (array_diff_assoc($leftRow, $rightRow)) {
                $rightDB->update($table, $key, $leftRow);
            }

            $leftRow = $leftTable->fetchRow();
            $rightRow = $rightTable->fetchRow();
        } elseif ($leftRow[$key] < $rightRow[$key]) {
            $rightDB->insert($table, $key, $leftRow);
            $leftRow = $leftTable->fetchRow();
        } else {
            $rightRow = $rightTable->fetchRow();
        }
    }
}
