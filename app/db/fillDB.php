<?php

require dirname(__DIR__) . '../../vendor/autoload.php';

$faker = Faker\Factory::create('fr_FR');

require 'connexionDB.php';

// Nettoyage des tables
$pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
$pdo->exec("TRUNCATE TABLE contact");
$pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

echo 'Database nettoyée avec succès !';

// Créer des faux formulaires de contact
$content = implode(' ', $faker->words(6));
for ($i = 0; $i < 10; $i++) {
    $pdo->exec("INSERT INTO contact
                SET nom='{$faker->lastName}',
                    prenom='{$faker->firstName}',
                    email='{$faker->email}',
                    content='{$content}',
                    send_at='{$faker->date} {$faker->time}'
                ");
};

echo 'La table contact a été remplie avec succès !';