<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220223103601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ruoli (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, ruolo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE utenti CHANGE gestore_id gestore_id INT NULL DEFAULT 0');
        //$this->addSql('ALTER TABLE utenti ADD CONSTRAINT FK_D7F3FFCB6A226ABC FOREIGN KEY (ruolo_id) REFERENCES ruoli (id)');
        $this->addSql('CREATE INDEX IDX_D7F3FFCB6A226ABC ON utenti (ruolo_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        //$this->addSql('ALTER TABLE utenti DROP FOREIGN KEY FK_D7F3FFCB6A226ABC');
        $this->addSql('DROP TABLE ruoli');
        $this->addSql('DROP INDEX IDX_D7F3FFCB6A226ABC ON utenti');
        $this->addSql('ALTER TABLE utenti CHANGE gestore_id gestore_id INT DEFAULT 0');
    }
}
