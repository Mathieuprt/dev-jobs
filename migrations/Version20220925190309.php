<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220925190309 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidat ADD offre_id INT NOT NULL');
        $this->addSql('ALTER TABLE candidat ADD CONSTRAINT FK_6AB5B4714CC8505A FOREIGN KEY (offre_id) REFERENCES offres (id)');
        $this->addSql('CREATE INDEX IDX_6AB5B4714CC8505A ON candidat (offre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidat DROP FOREIGN KEY FK_6AB5B4714CC8505A');
        $this->addSql('DROP INDEX IDX_6AB5B4714CC8505A ON candidat');
        $this->addSql('ALTER TABLE candidat DROP offre_id');
    }
}
