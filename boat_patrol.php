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
    $allow_duplicate_batch = true;
    $form_processor = new FormProcessor($_POST);
    $form_processor->FormElementCleanUp();
    /*
     * Specify relevant batch table and form table as strings.
     */
    $batch_table = 'boat_patrol_batch';
    $db_table = 'boat_patrol';
    $form_processor->ProcessForm($database_controller, $batch_table, $db_table, $allow_duplicate_batch);

    header('Location: ' . basename(__FILE__) );
    exit();
}
/*
 * Use an array of arrays.
 * The first element per array is the database table.
 * Subsequent elements are the relevant columns.
 */
$table_columns = array(
    array('compliance_zones_2021', 'compliance_zones_id', 'description'));
$zones = $database_controller->SelectKeyPairs($table_columns[0]);

include 'includes/header.php';
include 'views/boat_patrol.html.php';
include 'includes/footer.php';
