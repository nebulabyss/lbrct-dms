<?php
include './includes/auth.php';
include 'pdo.php';
include 'classes/DatabaseController.php';

/**
 * @var $pdo
 */
$database_controller = new DatabaseController($pdo);
$title = 'Slipway usage report';
$form_action = basename(__FILE__);

if (isset($_POST['start_date'])) {
    $table_columns = array(
        array('compliance_zones', 'description'));

    $recreational = $database_controller->recreationalSlipwayReport($_POST['start_date'], $_POST['end_date']);
    $commercial = $database_controller->commercialSlipwayReport($_POST['start_date'], $_POST['end_date']);
}

include 'includes/header.php';
include 'views/slipway_patrol_report.html.php';
include 'includes/footer.php';

