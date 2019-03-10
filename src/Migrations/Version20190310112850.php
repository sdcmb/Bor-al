<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190310112850 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE produits (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(255) NOT NULL, marque VARCHAR(255) NOT NULL, modele VARCHAR(255) NOT NULL, categorie VARCHAR(255) NOT NULL, couleur VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, poids DOUBLE PRECISION DEFAULT NULL, dimension VARCHAR(255) DEFAULT NULL, matiere VARCHAR(255) DEFAULT NULL, image VARCHAR(1000) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE produit');
        $this->addSql('ALTER TABLE user ADD telephone VARCHAR(10) NOT NULL, ADD adresse VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, marque VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, modele VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, couleur VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, prix DOUBLE PRECISION NOT NULL, poids DOUBLE PRECISION DEFAULT NULL, dimension VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, matiere VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, description LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci, image VARCHAR(1000) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE produits');
        $this->addSql('ALTER TABLE user DROP telephone, DROP adresse');
    }
}
