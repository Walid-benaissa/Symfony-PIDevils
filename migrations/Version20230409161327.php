<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230409161327 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livraison DROP INDEX IDX_A60C9F1FA98E9EC9, ADD UNIQUE INDEX UNIQ_A60C9F1FA98E9EC9 (id_colis)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livraison DROP INDEX UNIQ_A60C9F1FA98E9EC9, ADD INDEX IDX_A60C9F1FA98E9EC9 (id_colis)');
    }
}
