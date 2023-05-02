<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230426222235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX id_vehicule_id ON location');
        $this->addSql('ALTER TABLE location CHANGE id_vehicule id_vehicule VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicule CHANGE discount_applied discount_applied TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location CHANGE id_vehicule id_vehicule INT NOT NULL');
        $this->addSql('CREATE INDEX id_vehicule_id ON location (id_vehicule)');
        $this->addSql('ALTER TABLE vehicule CHANGE discount_applied discount_applied TINYINT(1) DEFAULT NULL');
    }
}
