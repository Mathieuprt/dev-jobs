<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220925185904 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offres ADD societe_id INT NOT NULL');
        $this->addSql('ALTER TABLE offres ADD CONSTRAINT FK_C6AC3544FCF77503 FOREIGN KEY (societe_id) REFERENCES societe (id)');
        $this->addSql('CREATE INDEX IDX_C6AC3544FCF77503 ON offres (societe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offres DROP FOREIGN KEY FK_C6AC3544FCF77503');
        $this->addSql('DROP INDEX IDX_C6AC3544FCF77503 ON offres');
        $this->addSql('ALTER TABLE offres DROP societe_id');
    }
}
