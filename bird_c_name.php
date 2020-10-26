<?php
include './includes/auth.php';
include 'pdo.php';

$stmt = $pdo->prepare('SELECT common_name FROM birds_species
    WHERE common_name LIKE :prefix');
$stmt->execute(array( ':prefix' => $_REQUEST['term']."%"));

$retval = array();
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    $retval[] = $row['common_name'];
}

echo(json_encode($retval, JSON_PRETTY_PRINT));