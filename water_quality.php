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
if (isset($_FILES['userfile'])) {
    $uploaddir = __DIR__ . '/uploads/';
    $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

    move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);

    $dom = new DomDocument();
    $dom->loadHTMLFile($uploadfile, LIBXML_NOERROR);

    $wq_data = array();
    $finder = new DomXPath($dom);
    $classnames = ['data','data-marked'];


    $trList = $dom->getElementsByTagName('tr');
    $trList = $finder->query("//tr[contains(concat(' ', normalize-space(@class), ' '), ' $classnames[0] ') or contains(concat(' ', normalize-space(@class), ' '), ' $classnames[1] ')]");
    foreach ( $trList as $tr )  {
        $row = [];
        foreach ( $tr->getElementsByTagName("td") as $td )  {
            $row[] = trim($td->textContent);
        }
        $wq_data[] = $row;
    }

    $counter = 0;
    $marked = array();
    while ($counter < count($wq_data)) {

        $pieces = explode(' ', $wq_data[$counter][0]);
        unset($wq_data[$counter][0]);
        if ($wq_data[$counter][8] == "Marked") {
            $marked[] = $counter;
        }
        unset($wq_data[$counter][8]);
        array_unshift($wq_data[$counter], $pieces[0], $pieces[1]);
        $counter ++;
    }

    include 'includes/header.php';
    include 'views/water_quality.html.php';
    include 'includes/footer.php';







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
    include 'views/water_quality.html.php';
    include 'includes/footer.php';

}

