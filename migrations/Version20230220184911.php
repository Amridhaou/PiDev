<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230220184911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE certificat (num_certificat INT AUTO_INCREMENT NOT NULL, cours_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, identifiant VARCHAR(255) NOT NULL, date_examen DATE NOT NULL, resultat TINYINT(1) NOT NULL, INDEX IDX_27448F777ECF78B0 (cours_id), PRIMARY KEY(num_certificat)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours (code_cours INT AUTO_INCREMENT NOT NULL, nomination VARCHAR(255) NOT NULL, type VARCHAR(255) DEFAULT NULL, support VARCHAR(255) DEFAULT NULL, duree INT DEFAULT NULL, matiere VARCHAR(255) DEFAULT NULL, sujet VARCHAR(255) DEFAULT NULL, participants_nb INT DEFAULT NULL, date_publication DATE NOT NULL, tuteur VARCHAR(255) NOT NULL, contact VARCHAR(255) NOT NULL, PRIMARY KEY(code_cours)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE certificat ADD CONSTRAINT FK_27448F777ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (code_cours)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE certificat DROP FOREIGN KEY FK_27448F777ECF78B0');
        $this->addSql('DROP TABLE certificat');
        $this->addSql('DROP TABLE cours');
    }
}
