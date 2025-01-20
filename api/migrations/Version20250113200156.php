<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250113200156 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE action (id SERIAL NOT NULL, field_id INT NOT NULL, type VARCHAR(255) NOT NULL, completed_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, started_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, notes TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_47CC8C92443707B0 ON action (field_id)');
        $this->addSql('CREATE TABLE field (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, area INT NOT NULL, notes TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE resource (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, category VARCHAR(255) NOT NULL, unit_of_measure VARCHAR(255) NOT NULL, manufacturer VARCHAR(255) NOT NULL, composition JSON NOT NULL, type VARCHAR(255) NOT NULL, notes TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE resource_storage (id SERIAL NOT NULL, resource_id INT NOT NULL, quatity_added INT NOT NULL, added_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, notes TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9DAFCDC89329D25 ON resource_storage (resource_id)');
        $this->addSql('CREATE TABLE resource_usage (id SERIAL NOT NULL, action_id INT NOT NULL, resource_id INT NOT NULL, quatity_used INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FB5024429D32F035 ON resource_usage (action_id)');
        $this->addSql('CREATE INDEX IDX_FB50244289329D25 ON resource_usage (resource_id)');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C92443707B0 FOREIGN KEY (field_id) REFERENCES field (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE resource_storage ADD CONSTRAINT FK_9DAFCDC89329D25 FOREIGN KEY (resource_id) REFERENCES resource (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE resource_usage ADD CONSTRAINT FK_FB5024429D32F035 FOREIGN KEY (action_id) REFERENCES action (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE resource_usage ADD CONSTRAINT FK_FB50244289329D25 FOREIGN KEY (resource_id) REFERENCES resource (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE action DROP CONSTRAINT FK_47CC8C92443707B0');
        $this->addSql('ALTER TABLE resource_storage DROP CONSTRAINT FK_9DAFCDC89329D25');
        $this->addSql('ALTER TABLE resource_usage DROP CONSTRAINT FK_FB5024429D32F035');
        $this->addSql('ALTER TABLE resource_usage DROP CONSTRAINT FK_FB50244289329D25');
        $this->addSql('DROP TABLE action');
        $this->addSql('DROP TABLE field');
        $this->addSql('DROP TABLE resource');
        $this->addSql('DROP TABLE resource_storage');
        $this->addSql('DROP TABLE resource_usage');
    }
}
