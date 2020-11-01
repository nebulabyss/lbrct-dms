<?php
include './includes/auth.php';
include 'pdo.php';
include 'classes/DatabaseController.php';

/**
 * @var $pdo
 */
$database_controller = new DatabaseController($pdo);
$title = 'Transgression report';
$form_action = basename(__FILE__);

if (isset($_POST['start_date'])) {
    $table_columns = array(
        array('compliance_zones', 'description'));

    $transgressions = $database_controller->TransgressionsReport($_POST['start_date'], $_POST['end_date']);
}

include 'includes/header.php';
include 'views/transgressions_report.html.php';
include 'includes/footer.php';