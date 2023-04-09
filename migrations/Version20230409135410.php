<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230409135410 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE colis (id INT AUTO_INCREMENT NOT NULL, nb_items INT NOT NULL, description VARCHAR(150) NOT NULL, poids DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conducteur (utilisateur_id INT NOT NULL, b3 VARCHAR(150) NOT NULL, permis VARCHAR(150) NOT NULL, PRIMARY KEY(utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course (id_course INT AUTO_INCREMENT NOT NULL, point_depart VARCHAR(150) NOT NULL, point_destination VARCHAR(150) NOT NULL, distance DOUBLE PRECISION NOT NULL, prix DOUBLE PRECISION NOT NULL, statut_course VARCHAR(150) NOT NULL, PRIMARY KEY(id_course)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livraison (id_livraison INT AUTO_INCREMENT NOT NULL, id_client INT DEFAULT NULL, id_colis INT DEFAULT NULL, id_livreur INT DEFAULT NULL, adresse_expedition VARCHAR(150) NOT NULL, adresse_destinataire VARCHAR(150) NOT NULL, prix DOUBLE PRECISION NOT NULL, etat VARCHAR(150) NOT NULL, INDEX IDX_A60C9F1FE173B1B8 (id_client), INDEX IDX_A60C9F1FA98E9EC9 (id_colis), INDEX IDX_A60C9F1F35E7E71D (id_livreur), PRIMARY KEY(id_livraison)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id_contrat VARCHAR(255) NOT NULL, id INT DEFAULT NULL, id_vehicule INT DEFAULT NULL, date_debut DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', date_fin DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', lieu VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id_contrat)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre_course (id_offre VARCHAR(255) NOT NULL, matricule_vehicule INT DEFAULT NULL, cin_conducteur INT DEFAULT NULL, nb_passagers INT DEFAULT NULL, options_offre VARCHAR(255) DEFAULT NULL, statut_offre VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id_offre)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre_livraison (id VARCHAR(255) NOT NULL, prix_livraison DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotion (id_promotion VARCHAR(255) NOT NULL, taux DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id_promotion)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, message VARCHAR(150) NOT NULL, etat VARCHAR(150) NOT NULL, idUser INT DEFAULT NULL, INDEX IDX_CE606404FE6E88D7 (idUser), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(20) NOT NULL, prenom VARCHAR(30) NOT NULL, mail VARCHAR(100) NOT NULL, mdp VARCHAR(100) NOT NULL, num_tel VARCHAR(20) NOT NULL, role VARCHAR(30) NOT NULL, evaluation DOUBLE PRECISION NOT NULL, bloque TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicule (id_vehicule INT AUTO_INCREMENT NOT NULL, nom_v VARCHAR(255) NOT NULL, id INT NOT NULL, image VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, disponibilite TINYINT(1) NOT NULL, description VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id_vehicule)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voiture (immatriculation VARCHAR(30) NOT NULL, id INT DEFAULT NULL, modele VARCHAR(30) NOT NULL, marque VARCHAR(30) NOT NULL, etat VARCHAR(20) NOT NULL, photo VARCHAR(255) NOT NULL, INDEX IDX_E9E2810FBF396750 (id), PRIMARY KEY(immatriculation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE conducteur ADD CONSTRAINT FK_23677143FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1FE173B1B8 FOREIGN KEY (id_client) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1FA98E9EC9 FOREIGN KEY (id_colis) REFERENCES colis (id)');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1F35E7E71D FOREIGN KEY (id_livreur) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404FE6E88D7 FOREIGN KEY (idUser) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810FBF396750 FOREIGN KEY (id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE utilisateur_utilisateur ADD CONSTRAINT FK_E9FA6E203E2745F8 FOREIGN KEY (utilisateur_source) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_utilisateur ADD CONSTRAINT FK_E9FA6E2027C21577 FOREIGN KEY (utilisateur_target) REFERENCES utilisateur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur_utilisateur DROP FOREIGN KEY FK_E9FA6E203E2745F8');
        $this->addSql('ALTER TABLE utilisateur_utilisateur DROP FOREIGN KEY FK_E9FA6E2027C21577');
        $this->addSql('ALTER TABLE conducteur DROP FOREIGN KEY FK_23677143FB88E14F');
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1FE173B1B8');
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1FA98E9EC9');
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1F35E7E71D');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404FE6E88D7');
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810FBF396750');
        $this->addSql('DROP TABLE colis');
        $this->addSql('DROP TABLE conducteur');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE livraison');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE offre_course');
        $this->addSql('DROP TABLE offre_livraison');
        $this->addSql('DROP TABLE promotion');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE vehicule');
        $this->addSql('DROP TABLE voiture');
    }
}
