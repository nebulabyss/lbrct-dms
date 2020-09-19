<?php


class DatabaseController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    private function query($pdo, $sql, $parameters = [])
    {
        $query = $pdo->prepare($sql);
        $query->execute($parameters);
        return $query;
    }
}