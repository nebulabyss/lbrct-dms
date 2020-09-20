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

    $batch_table = 'boat_patrols_batch';
    $db_table = 'boat_patrols';
    $form_processing->processForm($_POST, $batch_table, $db_table);

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
    $zones = $form_processing->selectKeyPairs($table_columns[0]);
    $trans = $form_processing->selectKeyPairs($table_columns[1]);

    include 'html/header.php';
    include 'html/boat_patrols.html.php';
    include 'html/footer.php';
}