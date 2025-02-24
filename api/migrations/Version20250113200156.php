<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250113200156 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create fields and actions tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE actions (
                action_id VARCHAR(255) NOT NULL, 
                field_id VARCHAR(255) NOT NULL, 
                type VARCHAR(255) NOT NULL, 
                completed_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
                notes TEXT DEFAULT NULL, 
            PRIMARY KEY(action_id))'
        );
        $this->addSql('CREATE INDEX IDX_47CC8C92443707B0 ON actions (field_id)');
        $this->addSql('
            CREATE TABLE fields (
                field_id VARCHAR(255) NOT NULL,
                name VARCHAR(255) NOT NULL,
                size INT NOT NULL,
                notes TEXT DEFAULT NULL,
            PRIMARY KEY(field_id))'
        );
        $this->addSql('
            ALTER TABLE actions
                ADD CONSTRAINT FK_47CC8C92443707B0 
                FOREIGN KEY (field_id)
                REFERENCES fields (field_id)'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE actions DROP CONSTRAINT FK_47CC8C92443707B0');
        $this->addSql('DROP TABLE actions');
        $this->addSql('DROP TABLE fields');
    }
}
