<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241106160832 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create contact table';
    }

    public function up(Schema $schema): void
    {
        // Création de la table contact
        $this->addSql('CREATE TABLE contact (
            id INT AUTO_INCREMENT NOT NULL,
            nom VARCHAR(255) NOT NULL,
            prenom VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            contact_reason VARCHAR(255) NOT NULL,
            content TEXT NOT NULL,
            send_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // Suppression de la table contact
        $this->addSql('DROP TABLE contact');
    }
}
