<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220223101300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utenti DROP FOREIGN KEY FK_D7F3FFCBFEF84283');
        $this->addSql('DROP TABLE tipi_utente');
        $this->addSql('DROP INDEX IDX_D7F3FFCBFEF84283 ON utenti');
        $this->addSql('ALTER TABLE utenti DROP tipoutente_id, CHANGE gestore_id gestore_id INT NULL DEFAULT 0');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tipi_utente (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE utenti ADD tipoutente_id INT NOT NULL, CHANGE gestore_id gestore_id INT DEFAULT 0');
        $this->addSql('ALTER TABLE utenti ADD CONSTRAINT FK_D7F3FFCBFEF84283 FOREIGN KEY (tipoutente_id) REFERENCES tipi_utente (id)');
        $this->addSql('CREATE INDEX IDX_D7F3FFCBFEF84283 ON utenti (tipoutente_id)');
    }
}
