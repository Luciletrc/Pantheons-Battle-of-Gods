<?php

//DB Connect
require 'connexionDB.php';

$pdo->exec("DROP TABLE contact");

echo 'Database contact supprimée avec succès!';