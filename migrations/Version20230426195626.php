<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230426195626 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY fk_vehicule_contrat');
        $this->addSql('DROP INDEX fk_vehicule_contrat ON location');
        $this->addSql('ALTER TABLE vehicule ADD discount_applied TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location ADD CONSTRAINT fk_vehicule_contrat FOREIGN KEY (id_vehicule) REFERENCES vehicule (id_vehicule) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('CREATE INDEX fk_vehicule_contrat ON location (id_vehicule)');
        $this->addSql('ALTER TABLE vehicule DROP discount_applied');
    }
}
