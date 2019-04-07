<?php

namespace MySqlSync\Model;

/**
 * Result
 */
class Table
{
    const ROWS_LIMIT = 1000;

    protected $db;
    protected $table;
    protected $orderBy;

    protected $result;

    protected $rowsTotalNumber;
    protected $rowsCurrentOffset;
    protected $lastRowId;

    function __construct($db, $table, $orderBy)
    {
        $this->db = $db;
        $this->table = $table;
        $this->orderBy = $orderBy;

        $this->rowsCurrentOffset = 0;
        $this->lastRowId = 0;

        $result = $db->query('select count(*) from ' . $table);
        if ($result) {
            $this->rowsTotalNumber = $result->fetch_row()[0];
        } else {
            throw new \Exception("Unable to open table: " . $table);
        }
    }

    public function __destruct()
    {
        if ($this->result) {
            $this->result->free();
        }
    }

    public function fetchRow()
    {
        if (!$this->result) {
            if ($this->rowsCurrentOffset >= $this->rowsTotalNumber) {
                return NULL;
            }

            $query = sprintf(
                'select * from %s where %s > %s order by %s asc limit %s',
                $this->table,
                $this->orderBy,
                $this->lastRowId,
                $this->orderBy,
                self::ROWS_LIMIT
            );

            $this->result = $this->db->query($query);
            $this->rowsCurrentOffset += self::ROWS_LIMIT;
        }

        /* fetch associative array */
        $row = $this->result->fetch_assoc();

        if ($row) {
            $this->lastRowId = $row[$this->orderBy];
            return $row;
        } else {
            /* free result set */
            $this->result->free();

            $this->result = NULL;

            return $this->fetchRow();
        }

        return NULL;
    }
}
