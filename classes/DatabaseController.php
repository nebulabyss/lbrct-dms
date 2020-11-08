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

    public function GetPrivilegeLevel()
    {
        $sql = 'SELECT privileges FROM users WHERE user_id = :user_id';
        $query = $this->pdo->prepare($sql);
        $query->execute(array(':user_id' => $_SESSION['USER_ID']));
        return $query->fetch(PDO::FETCH_COLUMN);
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

    public function UserAuthentication($email)
    {
        $sql = 'SELECT user_id, fname, lname, pwd FROM users WHERE email = :email';
        $query = $this->pdo->prepare($sql);
        $query->execute(array(':email' => $email));
        return $query->fetch(PDO::FETCH_ASSOC);
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

    public function SelectTransgressions()
    {
        $query = $this->pdo->prepare('
                SELECT
                    boat_patrol.boat_patrol_id, 
                    boat_patrol_batch.date, 
                    boat_patrol.breede, 
                    boat_patrol.licence, 
                    boat_patrol.bname, 
                    boat_patrol.samsa, 
                    boat_patrol.size
                FROM
                    boat_patrol
                    INNER JOIN
                    boat_patrol_batch
                    ON 
                        boat_patrol.batch_id = boat_patrol_batch.batch_id
                WHERE
                    boat_patrol.trans = 1 AND
                    boat_patrol_batch.batch_id = boat_patrol.batch_id
                    
                ORDER BY
                boat_patrol.boat_patrol_id
        ');
        $query->execute(array());
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function CheckForTransgressions()
    {
        $query = $this->pdo->prepare('
                SELECT
                    boat_patrol.trans
                FROM
                    boat_patrol
                WHERE
                    boat_patrol.trans = 1                    
        ');
        $query->execute(array());
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function UpdateTransgression($id)
    {
        $stmt = $this->pdo->prepare('
                UPDATE
                    boat_patrol
                SET boat_patrol.trans = 0
                WHERE
                    boat_patrol.boat_patrol_id = :id
        ');
        $stmt->execute(array(':id' => $id));
    }

    public function SelectBoatId($id)
    {
        $query = $this->pdo->prepare('
                SELECT
                    boat_patrol.boat_patrol_id, 
                    boat_patrol_batch.date, 
                    boat_patrol.breede, 
                    boat_patrol.licence, 
                    boat_patrol.bname, 
                    boat_patrol.samsa, 
                    boat_patrol.size
                FROM
                    boat_patrol
                    INNER JOIN
                    boat_patrol_batch
                    ON 
                        boat_patrol.batch_id = boat_patrol_batch.batch_id
                WHERE
                    boat_patrol.boat_patrol_id = :id AND
                    boat_patrol_batch.batch_id = boat_patrol.batch_id
                ORDER BY
                boat_patrol.boat_patrol_id
        ');
        $query->execute(array(':id' => $id));
        return $query->fetchAll(PDO::FETCH_ASSOC);
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

    public function birdCountReport($start_date, $end_date)
    {
        $query = $this->pdo->prepare("
                SELECT
                    birds_species.common_name,
                    SUM(bird_count.count)
                FROM
                    birds_species, bird_count
                WHERE
                    bird_count.species = birds_species.bird_id AND 
                    bird_count.batch_id IN(
                    SELECT
                        bird_count_batch.batch_id
                    FROM
                        bird_count_batch
                    WHERE
                        bird_count_batch.date BETWEEN :start_date AND :end_date
                )
                GROUP BY birds_species.common_name
        ");
        $query->execute(array(':start_date' => $start_date, ':end_date' => $end_date));
        return $query->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    public function birdGrandTotalReport($start_date, $end_date)
    {
        $query = $this->pdo->prepare("
                SELECT
                    SUM(bird_count.count)
                FROM
                bird_count
                WHERE
                        bird_count.batch_id IN(
                    SELECT
                        bird_count_batch.batch_id
                    FROM
                        bird_count_batch
                    WHERE
                        bird_count_batch.date BETWEEN :start_date AND :end_date
                )
        ");
        $query->execute(array(':start_date' => $start_date, ':end_date' => $end_date));
        return $query->fetchAll(PDO::FETCH_COLUMN);
    }

    public function MarineDebrisCountReport($start_date, $end_date)
    {
        $query = $this->pdo->prepare("
                SELECT
                    marine_debris_major_categories.description, 
                    SUM(marine_debris.count)
                FROM
                    marine_debris
                    INNER JOIN
                    marine_debris_minor_categories
                    ON 
                        marine_debris.item = marine_debris_minor_categories.marine_debris_minor_categories_id
                    INNER JOIN
                    marine_debris_major_categories
                    ON 
                        marine_debris_minor_categories.marine_debris_major_categories_id = marine_debris_major_categories.marine_debris_major_categories_id
                    WHERE
                        marine_debris.batch_id IN(
                    SELECT
                        marine_debris_batch.batch_id
                    FROM
                        marine_debris_batch
                    WHERE
                        marine_debris_batch.date BETWEEN :start_date AND :end_date
                )
                GROUP BY
                    marine_debris_major_categories.description
	");
        $query->execute(array(':start_date' => $start_date, ':end_date' => $end_date));
        return $query->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    public function MarineDebrisGrandTotalReport($start_date, $end_date)
    {
        $query = $this->pdo->prepare("
                SELECT
                    SUM(marine_debris.count)
                FROM
                marine_debris
                WHERE
                        marine_debris.batch_id IN(
                    SELECT
                        marine_debris_batch.batch_id
                    FROM
                        marine_debris_batch
                    WHERE
                        marine_debris_batch.date BETWEEN :start_date AND :end_date
                )
        ");
        $query->execute(array(':start_date' => $start_date, ':end_date' => $end_date));
        return $query->fetchAll(PDO::FETCH_COLUMN);
    }

    public function WaterQuality($start_date, $end_date)
    {
        $query = $this->pdo->prepare("
                SELECT
                    water_quality_sites.description,
                    ROUND(water_quality.sal, 2),
                    ROUND(water_quality.temp, 2) 
                FROM
                    water_quality
                    INNER JOIN water_quality_batch ON water_quality.batch_id = water_quality_batch.batch_id
                    INNER JOIN water_quality_sites ON water_quality_batch.site = water_quality_sites.id
                    INNER JOIN ( SELECT water_quality.batch_id, MAX( water_quality.depth ) AS MaxDepth FROM water_quality WHERE water_quality.marked = 1 GROUP BY water_quality.batch_id ) AS CompareTable ON water_quality.batch_id = CompareTable.batch_id 
                    AND water_quality.depth = CompareTable.MaxDepth 
                WHERE
                    water_quality.batch_id IN ( SELECT water_quality_batch.batch_id FROM water_quality_batch WHERE water_quality_batch.date BETWEEN :start_date AND :end_date ) 
                GROUP BY
                    water_quality_sites.description,
                    water_quality.sal,
                    water_quality.temp,
                    water_quality_sites.id 
                ORDER BY
                    water_quality_sites.id
        ");
        $query->execute(array(':start_date' => $start_date, ':end_date' => $end_date));
        return $query->fetchAll(PDO::FETCH_NUM);
    }

    public function TransgressionsReport($start_date, $end_date)
    {
        $query = $this->pdo->prepare("
                    SELECT
                        transgression_types.description, 
                        COUNT(transgressions.warning), 
                        COUNT(transgressions.fine)
                    FROM
                        boat_patrol
                        INNER JOIN
                        boat_patrol_batch
                        ON 
                            boat_patrol.batch_id = boat_patrol_batch.batch_id
                        INNER JOIN
                        transgressions
                        ON 
                            boat_patrol.boat_patrol_id = transgressions.boat_patrol_id
                        INNER JOIN
                        transgression_types
                        ON 
                            transgressions.trans_type = transgression_types.transgression_id
                    WHERE
	                     boat_patrol.batch_id IN (
                    SELECT
                        boat_patrol_batch.batch_id 
                    FROM
                        boat_patrol_batch 
                    WHERE
                        boat_patrol_batch.date BETWEEN :start_date AND :end_date )  
                    GROUP BY transgression_types.description, transgression_id
                    ORDER BY transgression_types.transgression_id
        ");
        $query->execute(array(':start_date' => $start_date, ':end_date' => $end_date));
        return $query->fetchAll(PDO::FETCH_NUM);
    }

    public function WaterQualityDates() {
        $query = $this->pdo->prepare("
        SELECT date FROM water_quality_batch WHERE date < CURDATE() GROUP BY date
        ");
        $query->execute(array());
        return $query->fetchAll(PDO::FETCH_COLUMN);
    }
}