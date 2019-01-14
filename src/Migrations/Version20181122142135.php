<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181122142135 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE produit CHANGE description description LONGTEXT NOT NULL, CHANGE image image VARCHAR(1000) NOT NULL');
        $this->addSql('ALTER TABLE user ADD prenom VARCHAR(255) NOT NULL, ADD nom VARCHAR(255) NOT NULL, DROP userfirstname, DROP userlastname');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE produit CHANGE description description VARCHAR(1000) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE image image VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user ADD userfirstname VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD userlastname VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP prenom, DROP nom');
    }
}
