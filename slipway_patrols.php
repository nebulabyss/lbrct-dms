<?php
include 'pdo.php';
include 'classes/FormProcessor.php';
include 'classes/DatabaseController.php';
session_start();

/**
 * @var $pdo
 */
$form_processor = new FormProcessor($_POST);
$database_controller = new DatabaseController($pdo);
if (isset($_POST['date'])) {
    $form_processor->FormElementCleanUp();
    /*
     * Specify relevant batch table and form table as strings.
     */
    $batch_table = 'slipway_patrols_batch';
    $db_table = 'slipway_patrols';
    $form_processor->processForm($database_controller, $batch_table, $db_table);

} else {
    $table_columns = array(
        array('slipways', 'slipways_id', 'description'),
        array('slipway_activities', 'activity_id', 'description')
    );
    $slipways = $database_controller->selectKeyPairs($table_columns[0]);
    $activity = $database_controller->selectKeyPairs($table_columns[1]);

    include 'includes/header.php';
    include 'views/slipway_patrols.html.php';
    include 'includes/footer.php';
}


