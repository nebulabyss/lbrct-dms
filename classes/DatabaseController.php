<?php


class DatabaseController
{
    private PDO $pdo;

    function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function GetLastInsertID()
    {
        return $this->pdo->lastInsertId();
    }

    public function InsertIntoDatabase($form_data, $table, $last_batch_id = 0)
    {
        if ($last_batch_id != 0) {
            $form_data['batch_id'] = $last_batch_id;
        }
        $sql = 'INSERT INTO ' . $table . ' (';
        foreach ($form_data as $k => $v) {
            $sql .= $k . ', ';
        }
        $sql = rtrim($sql, ', ');
        $sql .= ') VALUES (';

        foreach ($form_data as $k => $v) {
            $sql .= ':' . $k . ', ';
        }
        $sql = rtrim($sql, ', ');
        $sql .= ')';

        $data = array();
        foreach ($form_data as $k => $v) {
            $k = ':' . $k;
            $data[$k] = $v;
        }

        $stmt = $this->pdo->prepare($sql);

        try {
            $stmt->execute($data);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }

    }

    public function SelectKeyPairs(array $table_columns)
    {
        $sql = 'SELECT ' . implode(', ', (array_slice($table_columns, 1))) . ' FROM ' . $table_columns[0];
        $query = $this->pdo->prepare($sql);
        $query->execute(array());
        return $query->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    public function SelectColumn(array $table_columns)
    {
        $sql = 'SELECT ' . $table_columns[1] . ' FROM ' . $table_columns[0];
        $query = $this->pdo->prepare($sql);
        $query->execute(array());
        return $query->fetchAll(PDO::FETCH_COLUMN );
    }

    public function CheckIfBatchExists($date, $table)
    {
        $return_value = false;
        $column = 'batch_id';
        $stmt = $this->pdo->prepare('SELECT ' . $column . ' FROM ' . $table . ' WHERE date = :date');
        $stmt->execute(array(':date' => $date));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row !== false) $return_value = $row['batch_id'];
        return $return_value;
    }
}