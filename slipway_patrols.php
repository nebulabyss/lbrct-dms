<?php
include 'pdo.php';
include 'classes/DatabaseController.php';
session_start();

/**
 * @var $pdo
 */
$form_processing = new DatabaseController($pdo);
if (isset($_POST['date'])) {
    /*
     * Clean up elements that expect integers in database and set checkboxes to integer 1.
     */
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
    /*
     * Specify relevant batch table and form table as strings.
     */
    $batch_table = 'slipway_patrols_batch';
    $db_table = 'slipway_patrols';
    $form_processing->processForm($_POST, $batch_table, $db_table);

} else {
    $table_columns = array(
        array('slipways', 'slipways_id', 'description'),
        array('slipway_activities', 'activity_id', 'description')
    );
    $slipways = $form_processing->selectKeyPairs($table_columns[0]);
    $activity = $form_processing->selectKeyPairs($table_columns[1]);

    include 'includes/header.php';
    include 'views/slipway_patrols.html.php';
    include 'includes/footer.php';
}


