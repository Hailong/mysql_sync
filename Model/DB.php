<?php

namespace MySqlSync\Model;

use MySqlSync\Config\Config;

/**
 * DB
 */
class DB
{
    protected $connection;

    protected $opened_tables;

    public function __construct($host, $username, $password, $database)
    {
        $this->connection = new \mysqli($host, $username, $password, $database);

        /* check connection */
        if ($this->connection->connect_errno) {
            printf("Connect failed: %s\n", $this->connection->connect_error);
            exit();
        }
    }

    public function __destruct()
    {
        foreach ($this->opened_tables as $result) {
            unset($result);
        }

        /* close connection */
        if ($this->connection) {
            $this->connection->close();
        }
    }

    public function query($query)
    {
        $result = $this->connection->query($query);

        if (!$result) {
            echo "DB query failed, query: " . $query . PHP_EOL;
        }

        return $result;
    }

    public function escapeValue($value)
    {
        if ($value === NULL) {
            return 'NULL';
        }

        if (preg_match('/^0.*$/', $value)) {
            return "'" . $this->connection->real_escape_string($value) . "'";
        }

        if (preg_match('/[a-zA-Z]+/', $value)) {
            return "'" . $this->connection->real_escape_string($value) . "'";
        }

        if (is_numeric($value)) {
            return $value;
        }

        if (is_string($value)) {
            return "'" . $this->connection->real_escape_string($value) . "'";
        }

        return $value;
    }

    public function insert($table, $key, $data)
    {
        $values = [];
        foreach (array_values($data) as $value) {
            $values[] = $this->escapeValue($value);
        }

        $query = sprintf(
            'insert into %s (%s) values (%s)',
            $table,
            implode(',', array_keys($data)),
            implode(',', $values)
        );


        if (Config::DRY_RUN) {
            echo '[INSERT] ' . $query . PHP_EOL;
            return;
        }

        echo PHP_EOL . 'Inserting to ' . $table . ', key: ' . $data[$key] . PHP_EOL;

        $this->query($query);
    }

    public function update($table, $key, $data)
    {
        $fields = [];

        foreach ($data as $name => $value) {
            if ($name == $key) {
                continue;
            }

            $fields[] = $name . '=' . $this->escapeValue($value);
        }

        $query = sprintf(
            'update %s set %s where %s=%s',
            $table,
            implode(',', $fields),
            $key,
            $data[$key]
        );


        if (Config::DRY_RUN) {
            echo '[UPDATE] ' . $query . PHP_EOL;
            return;
        }

        echo PHP_EOL . 'Updating to ' . $table . ', key: ' . $data[$key] . PHP_EOL;

        $this->query($query);
    }

    public function openTable($table, $orderBy) {
        if (!isset($this->opened_tables[$table])) {
            $this->opened_tables[$table] = new Table(
                $this, $table, $orderBy
            );
        }

        return $this->opened_tables[$table];
    }
}
