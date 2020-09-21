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
    $batch_table = 'boat_patrols_batch';
    $db_table = 'boat_patrols';
    $form_processor->processForm($database_controller, $batch_table, $db_table);

} else {
    /*
     * Use an array of arrays.
     * The first element per array is the database table.
     * Subsequent elements are the relevant columns.
     */
    $table_columns = array(
        array('compliance_zones', 'compliance_zones_id', 'description'),
        array('transgression_types', 'transgression_id', 'section')
    );
    $zones = $database_controller->SelectKeyPairs($table_columns[0]);
    $trans = $database_controller->SelectKeyPairs($table_columns[1]);

    include 'includes/header.php';
    include 'views/boat_patrols.html.php';
    include 'includes/footer.php';
}