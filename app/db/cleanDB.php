<?php

//Nettoie la BDD sans être obligé de la supprimer à chaque fois

require 'connexionDB.php';

$pdo->exec("TRUNCATE contact");

echo 'Database contact vidée avec succès!';