<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250107152511 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE field (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, area INT NOT NULL, notes TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE field_land_parcel (field_id INT NOT NULL, land_parcel_id INT NOT NULL, PRIMARY KEY(field_id, land_parcel_id))');
        $this->addSql('CREATE INDEX IDX_A71FF860443707B0 ON field_land_parcel (field_id)');
        $this->addSql('CREATE INDEX IDX_A71FF8606DD090D3 ON field_land_parcel (land_parcel_id)');
        $this->addSql('CREATE TABLE field_action (id SERIAL NOT NULL, field_id INT NOT NULL, type VARCHAR(255) NOT NULL, completed_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, notes TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6D880090443707B0 ON field_action (field_id)');
        $this->addSql('CREATE TABLE land_parcel (id SERIAL NOT NULL, parcel_id VARCHAR(255) NOT NULL, parcel_type VARCHAR(255) NOT NULL, country_code VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE resource (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, unit_of_measure VARCHAR(255) NOT NULL, manufacturer VARCHAR(255) NOT NULL, composition JSON DEFAULT NULL, notes TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE resource_storage (id SERIAL NOT NULL, resource_id INT NOT NULL, quantity_added INT NOT NULL, added_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, notes TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9DAFCDC89329D25 ON resource_storage (resource_id)');
        $this->addSql('CREATE TABLE resource_usage (id SERIAL NOT NULL, resource_id INT NOT NULL, field_action_id INT NOT NULL, quantity_used INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FB50244289329D25 ON resource_usage (resource_id)');
        $this->addSql('CREATE INDEX IDX_FB502442783176BF ON resource_usage (field_action_id)');
        $this->addSql('CREATE TABLE supplier (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, vat_id VARCHAR(255) DEFAULT NULL, address TEXT DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE field_land_parcel ADD CONSTRAINT FK_A71FF860443707B0 FOREIGN KEY (field_id) REFERENCES field (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE field_land_parcel ADD CONSTRAINT FK_A71FF8606DD090D3 FOREIGN KEY (land_parcel_id) REFERENCES land_parcel (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE field_action ADD CONSTRAINT FK_6D880090443707B0 FOREIGN KEY (field_id) REFERENCES field (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE resource_storage ADD CONSTRAINT FK_9DAFCDC89329D25 FOREIGN KEY (resource_id) REFERENCES resource (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE resource_usage ADD CONSTRAINT FK_FB50244289329D25 FOREIGN KEY (resource_id) REFERENCES resource (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE resource_usage ADD CONSTRAINT FK_FB502442783176BF FOREIGN KEY (field_action_id) REFERENCES field_action (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE field_land_parcel DROP CONSTRAINT FK_A71FF860443707B0');
        $this->addSql('ALTER TABLE field_land_parcel DROP CONSTRAINT FK_A71FF8606DD090D3');
        $this->addSql('ALTER TABLE field_action DROP CONSTRAINT FK_6D880090443707B0');
        $this->addSql('ALTER TABLE resource_storage DROP CONSTRAINT FK_9DAFCDC89329D25');
        $this->addSql('ALTER TABLE resource_usage DROP CONSTRAINT FK_FB50244289329D25');
        $this->addSql('ALTER TABLE resource_usage DROP CONSTRAINT FK_FB502442783176BF');
        $this->addSql('DROP TABLE field');
        $this->addSql('DROP TABLE field_land_parcel');
        $this->addSql('DROP TABLE field_action');
        $this->addSql('DROP TABLE land_parcel');
        $this->addSql('DROP TABLE resource');
        $this->addSql('DROP TABLE resource_storage');
        $this->addSql('DROP TABLE resource_usage');
        $this->addSql('DROP TABLE supplier');
    }
}
