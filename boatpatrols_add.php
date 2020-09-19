<?php
require 'pdo.php';
session_start();

$no_data = 'No data received from database server: on ';

if (isset($_POST['date'])) {
    //print("<pre>".print_r($_POST,true)."</pre>");

    if (isset($pdo)) {
        $stmt = $pdo->prepare(
            'INSERT INTO batch_boat_patrol
            (date, start_time, end_time) VALUES 
            (:date, :st, :et)'
        );
        try {
            $stmt->execute(
                array(
                    ':date' => $_POST['date'],
                    ':st' => $_POST['start_time'],
                    ':et' => $_POST['end_time']
                )
            );
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }

        $last_batch_id = $pdo->lastInsertId();
        echo 'lastInsertId: ' . $last_batch_id;

        $counter = 0;
        while ($counter < count($_POST['row'])) {

            foreach ($_POST['row'][$counter] as $k => $v) {
                if ($_POST['row'][$counter][$k] == ''){
                    $_POST['row'][$counter][$k] = NULL;
                }
            }

            if (isset($_POST['row'][$counter]['twin'])) {
                $_POST['row'][$counter]['twin'] = 1;
            } else {
                $_POST['row'][$counter]['twin'] = 0;
            }

            if (isset($_POST['row'][$counter]['fine'])) {
                $_POST['row'][$counter]['fine'] = 1;
            } else {
                $_POST['row'][$counter]['fine'] = 0;
            }

            if (isset($_POST['row'][$counter]['warn'])) {
                $_POST['row'][$counter]['warn'] = 1;
            } else {
                $_POST['row'][$counter]['warn'] = 0;
            }

            print("<pre>".print_r($_POST,true)."</pre>");

            $stmt = $pdo->prepare(
                    'INSERT INTO boat_patrols
            (batch_id, zone, breede, licence, samsa, size, twin, fine, warn, trans) VALUES
            (:bid, :zone, :breede, :licence, :samsa, :size, :twin, :fine, :warn, :trans)'
                );
                try {
                    $stmt->execute(
                        array(
                            ':bid' => $last_batch_id,
                            ':zone' => $_POST['row'][$counter]['zone'],
                            ':breede' => $_POST['row'][$counter]['breede'],
                            ':licence' => $_POST['row'][$counter]['licence'],
                            ':samsa' => $_POST['row'][$counter]['samsa'],
                            ':size' => $_POST['row'][$counter]['size'],
                            ':twin' => $_POST['row'][$counter]['twin'],
                            ':fine' => $_POST['row'][$counter]['fine'],
                            ':warn' => $_POST['row'][$counter]['warn'],
                            ':trans' => $_POST['row'][$counter]['trans']
                        )
                    );
                }
                catch (PDOException $e) {
                    echo $e->getMessage();
                    die();
                }
            $counter++;
        }
    } else {
        echo $no_data . 'POST';
        die();
    }

} else {
    if (isset($pdo)) {
        $stmt = $pdo->prepare('SELECT compliance_zones_id, description FROM compliance_zones');
        $stmt->execute(array());
        $zones = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        $stmt = $pdo->prepare('SELECT transgression_id, section FROM transgression_types');
        $stmt->execute(array());
        $trans = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        include 'html/header.php';
        include 'html/boat_patrols.html.php';
        include 'html/footer.php';

    } else {
        echo $no_data . 'FETCH';
        die();
    }
}
