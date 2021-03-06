<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210729144921 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE product ADD rack_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD8E86A33E FOREIGN KEY (rack_id) REFERENCES rack (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D34A04AD8E86A33E ON product (rack_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE product DROP CONSTRAINT FK_D34A04AD8E86A33E');
        $this->addSql('DROP INDEX IDX_D34A04AD8E86A33E');
        $this->addSql('ALTER TABLE product DROP rack_id');
        $this->addSql('ALTER TABLE product ALTER name TYPE VARCHAR(100)');
    }
}
