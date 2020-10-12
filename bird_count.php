<?php
include 'pdo.php';
include 'classes/FormProcessor.php';
include 'classes/DatabaseController.php';
session_start();

/**
 * @var $pdo
 */
// $form_processor = new FormProcessor($_POST);
$database_controller = new DatabaseController($pdo);
$allow_duplicate_batch = false;

/*
 * Use an array of arrays.
 * The first element per array is the database table.
 * Subsequent elements are the relevant columns.
 */
$table_columns = array(
    array('birds_behaviours', 'bird_behaviours_id', 'code'),
    array('birds_habitats', 'birds_habitats_id', 'code'),
    array('birds_minor_zones', 'birds_minor_zones_id', 'code')
);
$behavior_codes = $database_controller->SelectKeyPairs($table_columns[0]);
$habitat_codes = $database_controller->SelectKeyPairs($table_columns[1]);
$zones = $database_controller->SelectKeyPairs($table_columns[2]);

include 'includes/header.php';
include 'views/bird_count.html.php';
include 'includes/footer.php';
