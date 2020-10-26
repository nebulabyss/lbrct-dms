<?php
include './includes/auth.php';
include 'pdo.php';

if (isset($_POST['species_name']) && isset($_POST['species_type'])) {

    $stmt = $pdo->prepare('INSERT INTO birds_species (common_name, type) VALUES (:c_name, :type)');
    $stmt->execute(array(
            ':c_name' => $_POST['species_name'],
            ':type' => $_POST['species_type']
        )
    );
}