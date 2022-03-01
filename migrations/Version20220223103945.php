<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220223103945 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utenti CHANGE gestore_id gestore_id INT NULL DEFAULT 0');
        $this->addSql('ALTER TABLE utenti ADD CONSTRAINT FK_D7F3FFCB6A226ABC FOREIGN KEY (ruolo_id) REFERENCES ruoli (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utenti DROP FOREIGN KEY FK_D7F3FFCB6A226ABC');
        $this->addSql('ALTER TABLE utenti CHANGE gestore_id gestore_id INT DEFAULT 0');
    }
}
