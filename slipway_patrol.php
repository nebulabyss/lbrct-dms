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
    $batch_table = 'slipway_patrol_batch';
    $db_table = 'slipway_patrol';
    $form_processor->ProcessForm($database_controller, $batch_table, $db_table);

    header('Location: ' . basename(__FILE__) );
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



