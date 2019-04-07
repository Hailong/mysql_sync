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
            throw new \Exception("DB query failed, query: " . $query, 1);
        }

        return $result;
    }

    public function escapeValue($value)
    {
        if ($value === NULL) {
            return 'NULL';
        }

        if (is_numeric($value)) {
            return $value;
        }

        if (is_string($value)) {
            return "'" . $this->connection->real_escape_string($value) . "'";
        }

        return $value;
    }

    public function insert($table, $data)
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
            echo 'INSERT: ' . $query . PHP_EOL;
            return;
        }

        $result = $this->query($query);
        $result->close();
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
            echo 'UPDATE: ' . $query . PHP_EOL;
            return;
        }

        $result = $this->query($query);
        $result->close();
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
