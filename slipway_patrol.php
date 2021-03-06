<?php
include './includes/auth.php';
include 'pdo.php';
include 'classes/FormProcessor.php';
include 'classes/DatabaseController.php';

/**
 * @var $pdo
 */
$database_controller = new DatabaseController($pdo);
if (isset($_POST['date'])) {
    $allow_duplicate_batch = false;
    $form_processor = new FormProcessor($_POST);
    $form_processor->FormElementCleanUp();
    /*
     * Specify relevant batch table and form table as strings.
     */
    $batch_table = 'slipway_patrol_batch';
    $db_table = 'slipway_patrol';
    $form_processor->ProcessForm($database_controller, $batch_table, $db_table, $allow_duplicate_batch);

    header('Location: ' . basename(__FILE__));
    exit();
}
/*
 * Use an array of arrays.
 * The first element per array is the database table.
 * Subsequent elements are the relevant columns.
 */
$table_columns = array(
    array('slipways', 'slipways_id', 'description'),
    array('slipway_activities', 'activity_id', 'description')
);
$slipways = $database_controller->SelectKeyPairs($table_columns[0]);
$activity = $database_controller->SelectKeyPairs($table_columns[1]);

include 'includes/header.php';
include 'views/slipway_patrol.html.php';
include 'includes/footer.php';



