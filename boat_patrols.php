<?php
include 'pdo.php';
include 'classes/DatabaseController.php';
session_start();

/**
 * @var $pdo
 */

if (isset($_POST['date'])) {
    $counter = 0;
    while ($counter < count($_POST['row'])) {
        foreach ($_POST['row'][$counter] as $k => $v) {
            if ($_POST['row'][$counter][$k] == 'on') {
                $_POST['row'][$counter][$k] = 1;
                continue;
            }
            if ($_POST['row'][$counter][$k] == '') {
                $_POST['row'][$counter][$k] = NULL;
            }
        }
        $counter++;
    }
    //print("<pre>".print_r($_POST,true)."</pre>");

    $db_table = 'boat_patrols';
    $batch_table = 'boat_patrols_batch';
    $form_submit = new DatabaseController($pdo);
    // $columns = 'date, start_time, end_time';
    $form_submit->processForm($_POST, $batch_table, $db_table);

/*
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
*/
} else {
    $table_columns = array(
        array('compliance_zones', 'compliance_zones_id', 'description'),
        array('transgression_types', 'transgression_id', 'section')
    );
    $form_generate = new DatabaseController($pdo);
    $zones = $form_generate->selectKeyPairs($table_columns[0]);
    $trans = $form_generate->selectKeyPairs($table_columns[1]);

    include 'html/header.php';
    include 'html/boat_patrols.html.php';
    include 'html/footer.php';
}