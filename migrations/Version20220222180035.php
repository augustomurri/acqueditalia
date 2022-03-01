<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220222180035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comuni (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE erogazioni (id INT AUTO_INCREMENT NOT NULL, tessera_id INT NOT NULL, prodotto_id INT NOT NULL, quantita DOUBLE PRECISION NOT NULL, costo DOUBLE PRECISION NOT NULL, data_ora DATETIME NOT NULL, INDEX IDX_F7B403BD343274B8 (tessera_id), INDEX IDX_F7B403BDAB38982D (prodotto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prodotti (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, prezzo_unitario DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stazioni (id INT AUTO_INCREMENT NOT NULL, comune_id INT NOT NULL, nome VARCHAR(255) NOT NULL, INDEX IDX_E5A532F2885878B0 (comune_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tessere (id INT AUTO_INCREMENT NOT NULL, utente_id INT DEFAULT NULL, codice_tessera VARCHAR(255) NOT NULL, attiva TINYINT(1) NOT NULL, data_attivazione DATETIME DEFAULT NULL, INDEX IDX_7447A7AA6FD5D2A (utente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tipi_utente (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transazioni (id INT AUTO_INCREMENT NOT NULL, operatore_id INT NOT NULL, quantita DOUBLE PRECISION NOT NULL, data_ora DATETIME NOT NULL, INDEX IDX_3E46A730DD8402AC (operatore_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utenti (id INT AUTO_INCREMENT NOT NULL, gestore_id INT NOT NULL, tipoutente_id INT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, apitoken VARCHAR(255) NOT NULL, credito DOUBLE PRECISION NOT NULL, attivo TINYINT(1) NOT NULL, ultimo_login DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_D7F3FFCB13F5C4EC (gestore_id), INDEX IDX_D7F3FFCBFEF84283 (tipoutente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE erogazioni ADD CONSTRAINT FK_F7B403BD343274B8 FOREIGN KEY (tessera_id) REFERENCES tessere (id)');
        $this->addSql('ALTER TABLE erogazioni ADD CONSTRAINT FK_F7B403BDAB38982D FOREIGN KEY (prodotto_id) REFERENCES prodotti (id)');
        $this->addSql('ALTER TABLE stazioni ADD CONSTRAINT FK_E5A532F2885878B0 FOREIGN KEY (comune_id) REFERENCES comuni (id)');
        $this->addSql('ALTER TABLE tessere ADD CONSTRAINT FK_7447A7AA6FD5D2A FOREIGN KEY (utente_id) REFERENCES utenti (id)');
        $this->addSql('ALTER TABLE transazioni ADD CONSTRAINT FK_3E46A730DD8402AC FOREIGN KEY (operatore_id) REFERENCES utenti (id)');
        $this->addSql('ALTER TABLE utenti ADD CONSTRAINT FK_D7F3FFCB13F5C4EC FOREIGN KEY (gestore_id) REFERENCES utenti (id)');
        $this->addSql('ALTER TABLE utenti ADD CONSTRAINT FK_D7F3FFCBFEF84283 FOREIGN KEY (tipoutente_id) REFERENCES tipi_utente (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stazioni DROP FOREIGN KEY FK_E5A532F2885878B0');
        $this->addSql('ALTER TABLE erogazioni DROP FOREIGN KEY FK_F7B403BDAB38982D');
        $this->addSql('ALTER TABLE erogazioni DROP FOREIGN KEY FK_F7B403BD343274B8');
        $this->addSql('ALTER TABLE utenti DROP FOREIGN KEY FK_D7F3FFCBFEF84283');
        $this->addSql('ALTER TABLE tessere DROP FOREIGN KEY FK_7447A7AA6FD5D2A');
        $this->addSql('ALTER TABLE transazioni DROP FOREIGN KEY FK_3E46A730DD8402AC');
        $this->addSql('ALTER TABLE utenti DROP FOREIGN KEY FK_D7F3FFCB13F5C4EC');
        $this->addSql('DROP TABLE comuni');
        $this->addSql('DROP TABLE erogazioni');
        $this->addSql('DROP TABLE prodotti');
        $this->addSql('DROP TABLE stazioni');
        $this->addSql('DROP TABLE tessere');
        $this->addSql('DROP TABLE tipi_utente');
        $this->addSql('DROP TABLE transazioni');
        $this->addSql('DROP TABLE utenti');
    }
}
