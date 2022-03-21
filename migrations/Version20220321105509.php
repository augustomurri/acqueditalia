<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220321105509 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE ext_log_entries_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reset_password_request_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ruoli_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE comuni (id UUID NOT NULL, nome VARCHAR(255) NOT NULL, latitudine VARCHAR(255) NOT NULL, longitudine VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN comuni.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE erogazioni (id UUID NOT NULL, tessera_id UUID NOT NULL, prodotto_id UUID NOT NULL, stazione_id UUID NOT NULL, quantita DOUBLE PRECISION NOT NULL, costo DOUBLE PRECISION NOT NULL, data_ora TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F7B403BD343274B8 ON erogazioni (tessera_id)');
        $this->addSql('CREATE INDEX IDX_F7B403BDAB38982D ON erogazioni (prodotto_id)');
        $this->addSql('CREATE INDEX IDX_F7B403BDD11BDEC5 ON erogazioni (stazione_id)');
        $this->addSql('COMMENT ON COLUMN erogazioni.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN erogazioni.tessera_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN erogazioni.prodotto_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN erogazioni.stazione_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE ext_log_entries (id INT NOT NULL, action VARCHAR(8) NOT NULL, logged_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, object_id VARCHAR(64) DEFAULT NULL, object_class VARCHAR(191) NOT NULL, version INT NOT NULL, data TEXT DEFAULT NULL, username VARCHAR(191) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX log_class_lookup_idx ON ext_log_entries (object_class)');
        $this->addSql('CREATE INDEX log_date_lookup_idx ON ext_log_entries (logged_at)');
        $this->addSql('CREATE INDEX log_user_lookup_idx ON ext_log_entries (username)');
        $this->addSql('CREATE INDEX log_version_lookup_idx ON ext_log_entries (object_id, object_class, version)');
        $this->addSql('COMMENT ON COLUMN ext_log_entries.data IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE prodotti (id UUID NOT NULL, nome VARCHAR(255) NOT NULL, prezzo_unitario DOUBLE PRECISION NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN prodotti.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE reset_password_request (id INT NOT NULL, user_id UUID NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7CE748AA76ED395 ON reset_password_request (user_id)');
        $this->addSql('COMMENT ON COLUMN reset_password_request.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN reset_password_request.requested_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN reset_password_request.expires_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE ruoli (id INT NOT NULL, nome VARCHAR(255) NOT NULL, ruolo VARCHAR(20) NOT NULL, classe VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A77C65564E1FC063 ON ruoli (ruolo)');
        $this->addSql('CREATE TABLE stazioni (id UUID NOT NULL, gestore_id UUID NOT NULL, comune_id UUID NOT NULL, nome VARCHAR(255) NOT NULL, latitudine VARCHAR(255) NOT NULL, longitudine VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E5A532F213F5C4EC ON stazioni (gestore_id)');
        $this->addSql('CREATE INDEX IDX_E5A532F2885878B0 ON stazioni (comune_id)');
        $this->addSql('COMMENT ON COLUMN stazioni.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN stazioni.gestore_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN stazioni.comune_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE tessere (id UUID NOT NULL, utente_id UUID DEFAULT NULL, codice_tessera VARCHAR(255) NOT NULL, attiva BOOLEAN NOT NULL, data_attivazione TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7447A7AA6FD5D2A ON tessere (utente_id)');
        $this->addSql('COMMENT ON COLUMN tessere.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tessere.utente_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE transazioni (id UUID NOT NULL, operatore_id UUID NOT NULL, utente_id UUID NOT NULL, quantita DOUBLE PRECISION NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3E46A730DD8402AC ON transazioni (operatore_id)');
        $this->addSql('CREATE INDEX IDX_3E46A7306FD5D2A ON transazioni (utente_id)');
        $this->addSql('COMMENT ON COLUMN transazioni.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN transazioni.operatore_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN transazioni.utente_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE utenti (id UUID NOT NULL, gestore_id UUID DEFAULT NULL, comune_id UUID DEFAULT NULL, ruolo_id INT NOT NULL DEFAULT 2, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, nome VARCHAR(255) DEFAULT NULL, cognome VARCHAR(255) DEFAULT NULL, codice_fiscale VARCHAR(255) DEFAULT NULL, credito DOUBLE PRECISION DEFAULT \'0\' NOT NULL, is_verified BOOLEAN NOT NULL, apitoken VARCHAR(255) DEFAULT NULL, attivo BOOLEAN DEFAULT true NOT NULL, ultimo_login TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D7F3FFCBE7927C74 ON utenti (email)');
        $this->addSql('CREATE INDEX IDX_D7F3FFCB13F5C4EC ON utenti (gestore_id)');
        $this->addSql('CREATE INDEX IDX_D7F3FFCB885878B0 ON utenti (comune_id)');
        $this->addSql('CREATE INDEX IDX_D7F3FFCB6A226ABC ON utenti (ruolo_id)');
        $this->addSql('COMMENT ON COLUMN utenti.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN utenti.gestore_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN utenti.comune_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE erogazioni ADD CONSTRAINT FK_F7B403BD343274B8 FOREIGN KEY (tessera_id) REFERENCES tessere (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE erogazioni ADD CONSTRAINT FK_F7B403BDAB38982D FOREIGN KEY (prodotto_id) REFERENCES prodotti (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE erogazioni ADD CONSTRAINT FK_F7B403BDD11BDEC5 FOREIGN KEY (stazione_id) REFERENCES stazioni (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES utenti (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE stazioni ADD CONSTRAINT FK_E5A532F213F5C4EC FOREIGN KEY (gestore_id) REFERENCES utenti (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE stazioni ADD CONSTRAINT FK_E5A532F2885878B0 FOREIGN KEY (comune_id) REFERENCES comuni (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tessere ADD CONSTRAINT FK_7447A7AA6FD5D2A FOREIGN KEY (utente_id) REFERENCES utenti (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transazioni ADD CONSTRAINT FK_3E46A730DD8402AC FOREIGN KEY (operatore_id) REFERENCES utenti (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transazioni ADD CONSTRAINT FK_3E46A7306FD5D2A FOREIGN KEY (utente_id) REFERENCES utenti (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utenti ADD CONSTRAINT FK_D7F3FFCB13F5C4EC FOREIGN KEY (gestore_id) REFERENCES utenti (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utenti ADD CONSTRAINT FK_D7F3FFCB885878B0 FOREIGN KEY (comune_id) REFERENCES comuni (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utenti ADD CONSTRAINT FK_D7F3FFCB6A226ABC FOREIGN KEY (ruolo_id) REFERENCES ruoli (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE stazioni DROP CONSTRAINT FK_E5A532F2885878B0');
        $this->addSql('ALTER TABLE utenti DROP CONSTRAINT FK_D7F3FFCB885878B0');
        $this->addSql('ALTER TABLE erogazioni DROP CONSTRAINT FK_F7B403BDAB38982D');
        $this->addSql('ALTER TABLE utenti DROP CONSTRAINT FK_D7F3FFCB6A226ABC');
        $this->addSql('ALTER TABLE erogazioni DROP CONSTRAINT FK_F7B403BDD11BDEC5');
        $this->addSql('ALTER TABLE erogazioni DROP CONSTRAINT FK_F7B403BD343274B8');
        $this->addSql('ALTER TABLE reset_password_request DROP CONSTRAINT FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE stazioni DROP CONSTRAINT FK_E5A532F213F5C4EC');
        $this->addSql('ALTER TABLE tessere DROP CONSTRAINT FK_7447A7AA6FD5D2A');
        $this->addSql('ALTER TABLE transazioni DROP CONSTRAINT FK_3E46A730DD8402AC');
        $this->addSql('ALTER TABLE transazioni DROP CONSTRAINT FK_3E46A7306FD5D2A');
        $this->addSql('ALTER TABLE utenti DROP CONSTRAINT FK_D7F3FFCB13F5C4EC');
        $this->addSql('DROP SEQUENCE ext_log_entries_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reset_password_request_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ruoli_id_seq CASCADE');
        $this->addSql('DROP TABLE comuni');
        $this->addSql('DROP TABLE erogazioni');
        $this->addSql('DROP TABLE ext_log_entries');
        $this->addSql('DROP TABLE prodotti');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE ruoli');
        $this->addSql('DROP TABLE stazioni');
        $this->addSql('DROP TABLE tessere');
        $this->addSql('DROP TABLE transazioni');
        $this->addSql('DROP TABLE utenti');
    }
}
