<?php

// Db connection
require 'connexionDB.php';

// Create table
$pdo->exec("CREATE TABLE contact (
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    content text NOT NULL,
    send_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

echo 'tables : CONTACT';