<?php
include 'pdo.php';
include 'classes/FormProcessor.php';
include 'classes/DatabaseController.php';
session_start();

/**
 * @var $pdo
 */
$database_controller = new DatabaseController($pdo);
if (isset($_POST['date'])) {
    $form_processor = new FormProcessor($_POST);
    $form_processor->FormElementCleanUp();
    /*
     * Specify relevant batch table and form table as strings.
     */
    $batch_table = 'marine_debris_batch';
    $db_table = 'marine_debris';
    $form_processor->ProcessForm($database_controller, $batch_table, $db_table);

    header('Location: ' . basename(__FILE__) );
    exit();
}
/*
 * Use an array of arrays.
 * The first element per array is the database table.
 * Subsequent elements are the relevant columns.
 */
$table_columns = array(
    array('marine_debris_zones', 'marine_debris_zones_id', 'description')
);
$item_codes = $database_controller->MarineDebrisCodes();
$zones = $database_controller->SelectKeyPairs($table_columns[0]);

include 'includes/header.php';
include 'views/marine_debris.html.php';
include 'includes/footer.php';
