<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201124093247 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accueil (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_2994CBE7294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, redacteur_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, texte LONGTEXT NOT NULL, date_creation DATE NOT NULL, INDEX IDX_23A0E66764D0490 (redacteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rubrique (id INT AUTO_INCREMENT NOT NULL, redacteur_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, dropdown TINYINT(1) NOT NULL, INDEX IDX_8FA4097C764D0490 (redacteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_1D1C63B3E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accueil ADD CONSTRAINT FK_2994CBE7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66764D0490 FOREIGN KEY (redacteur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE rubrique ADD CONSTRAINT FK_8FA4097C764D0490 FOREIGN KEY (redacteur_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accueil DROP FOREIGN KEY FK_2994CBE7294869C');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66764D0490');
        $this->addSql('ALTER TABLE rubrique DROP FOREIGN KEY FK_8FA4097C764D0490');
        $this->addSql('DROP TABLE accueil');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE rubrique');
        $this->addSql('DROP TABLE utilisateur');
    }
}
