<?php
// This script stores the database connection 

$pdo = new PDO('mysql:host=localhost;port=3307;dbname=sample', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>