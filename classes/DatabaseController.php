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

        $stmt = $this->pdo->prepare($sql);

        try {
            $stmt->execute($form_data);
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
        return $query->fetchAll(PDO::FETCH_COLUMN);
    }

    public function CheckIfBatchExists($batch_data, $batch_table)
    {
        $batch_result = false;
        $column = 'batch_id';
        $sql = 'SELECT ' . $column . ' FROM ' . $batch_table . ' WHERE ';

        if (count($batch_data) > 1) {
            foreach ($batch_data as $k => $v) {
                $sql .= $k . ' = ' . ':' . $k . ' AND ';
            }
            $sql = rtrim($sql, ' AND ');
        } else {
            $sql .= key($batch_data) . ' = ' . ':' . key($batch_data);
        }

        $query = $this->pdo->prepare($sql);
        $query->execute($batch_data);
        $row = $query->fetch(PDO::FETCH_ASSOC);
        if ($row !== false) $batch_result = $row[$column];
        return $batch_result;
    }

    public function MarineDebrisCodes()
    {
        $query = $this->pdo->prepare('
            SELECT
                marine_debris_minor_categories.marine_debris_minor_categories_id,
                marine_debris_minor_categories.code,
                marine_debris_minor_categories.description,
                marine_debris_major_categories.description
            FROM
                marine_debris_minor_categories
            INNER JOIN marine_debris_major_categories WHERE marine_debris_minor_categories.marine_debris_major_categories_id = marine_debris_major_categories.marine_debris_major_categories_id;
        ');
        $query->execute(array());
        return $query->fetchAll(PDO::FETCH_NAMED);
    }

    public function CheckBirdName($bird_name)
    {
        $name_result = false;
        $table = 'birds_species';
        $column = 'bird_id';
        $sql = 'SELECT ' . $column . ' FROM ' . $table . ' WHERE common_name = :bird_name';

        $query = $this->pdo->prepare($sql);
        $query->execute(array(':bird_name' => $bird_name));
        $row = $query->fetch(PDO::FETCH_ASSOC);
        if ($row !== false) $name_result = (int)$row[$column];

        return $name_result;
    }

    public function zoneCountReportSum($start_date, $end_date)
    {
        $query = $this->pdo->prepare('
            SELECT
                SUM(compliance_zone_counts.transit),
                SUM(compliance_zone_counts.moored),
                SUM(compliance_zone_counts.skiing),
                SUM(compliance_zone_counts.fishing),
                SUM(compliance_zone_counts.other),
                SUM(compliance_zone_counts.angler),
                SUM(compliance_zone_counts.bait)
            FROM
                compliance_zone_counts
            WHERE
                compliance_zone_counts.batch_id IN(
                SELECT
                    compliance_zones_batch.batch_id
                FROM
                    compliance_zones_batch
                WHERE
                    compliance_zones_batch.date BETWEEN :start_date AND :end_date
                )
        ');
        $query->execute(array(':start_date' => $start_date, ':end_date' => $end_date));
        return $query->fetchAll(PDO::FETCH_NUM);
    }

    public function zoneCountReportMax($start_date, $end_date)
    {
        $query = $this->pdo->prepare('
            SELECT
                MAX(compliance_zone_counts.transit),
                MAX(compliance_zone_counts.moored),
                MAX(compliance_zone_counts.skiing),
                MAX(compliance_zone_counts.fishing),
                MAX(compliance_zone_counts.other),
                MAX(compliance_zone_counts.angler),
                MAX(compliance_zone_counts.bait)
            FROM
                compliance_zone_counts,
                compliance_zones_batch
            WHERE
                compliance_zone_counts.batch_id IN(
                SELECT
                    compliance_zones_batch.batch_id
                FROM
                    compliance_zones_batch
                WHERE
                    compliance_zones_batch.date BETWEEN :start_date AND :end_date
                )
        ');
        $query->execute(array(':start_date' => $start_date, ':end_date' => $end_date));
        return $query->fetchAll(PDO::FETCH_NUM);
    }

    public function boatPatrolReport($start_date, $end_date)
    {
        $query = $this->pdo->prepare("
                SELECT
                    COUNT(
                    DISTINCT boat_patrol.boat_patrol_id
                    )
                FROM
                    boat_patrol
                WHERE
                    boat_patrol.batch_id IN(
                    SELECT
                        boat_patrol_batch.batch_id
                    FROM
                        boat_patrol_batch
                    WHERE
                        boat_patrol_batch.date BETWEEN :start_date AND :end_date
                    )
        ");
        $query->execute(array(':start_date' => $start_date, ':end_date' => $end_date));
        return $query->fetchAll(PDO::FETCH_COLUMN);
    }

    public function commercialSlipwayReport($start_date, $end_date)
    {
        $query = $this->pdo->prepare("
                SELECT
                    COUNT(
                    DISTINCT slipway_patrol.slipway_patrol_id
                    )
                FROM
                    slipway_patrol
                WHERE
                    slipway_patrol.batch_id IN(
                    SELECT
                        slipway_patrol_batch.batch_id
                    FROM
                        slipway_patrol_batch
                    WHERE
                        slipway_patrol_batch.date BETWEEN :start_date AND :end_date
                    )
                AND slipway_patrol.licence = 'C'
        ");
        $query->execute(array(':start_date' => $start_date, ':end_date' => $end_date));
        return $query->fetchAll(PDO::FETCH_COLUMN);
    }

    public function recreationalSlipwayReport($start_date, $end_date)
    {
        $query = $this->pdo->prepare("
                SELECT
                    COUNT(slipway_patrol.slipway_patrol_id)
                FROM
                    slipway_patrol
                WHERE
                    slipway_patrol.batch_id IN(
                    SELECT
                        slipway_patrol_batch.batch_id
                    FROM
                        slipway_patrol_batch
                    WHERE
                        slipway_patrol_batch.date BETWEEN :start_date AND :end_date
                ) AND slipway_patrol.slipway_patrol_id NOT IN(
                    SELECT
                        slipway_patrol.slipway_patrol_id
                    FROM
                        slipway_patrol
                    WHERE
                        slipway_patrol.licence = 'C'
                    )
        ");
        $query->execute(array(':start_date' => $start_date, ':end_date' => $end_date));
        return $query->fetchAll(PDO::FETCH_COLUMN);
    }
}