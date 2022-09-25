<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220925185005 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE societe (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(100) NOT NULL, logo VARCHAR(255) NOT NULL, background_logo VARCHAR(255) NOT NULL, city VARCHAR(120) NOT NULL, website VARCHAR(255) NOT NULL, firstname_contact VARCHAR(100) NOT NULL, lastname_contact VARCHAR(100) NOT NULL, email VARCHAR(255) NOT NULL, phone_contact VARCHAR(35) NOT NULL, UNIQUE INDEX UNIQ_19653DBDAA08CB10 (login), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE societe');
    }
}
