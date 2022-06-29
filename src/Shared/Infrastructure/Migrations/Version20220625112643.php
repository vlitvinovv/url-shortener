<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220625112643 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE link_stat (ulid VARCHAR(26) NOT NULL, total_views_count BIGINT NOT NULL, unique_views_count BIGINT NOT NULL, path VARCHAR(255) NOT NULL, PRIMARY KEY(ulid))');
        $this->addSql('CREATE TABLE unique_view (ulid VARCHAR(26) NOT NULL, link_view_id VARCHAR(26) DEFAULT NULL, user_ip VARCHAR(39) NOT NULL, user_agent VARCHAR(255) NOT NULL, PRIMARY KEY(ulid))');
        $this->addSql('CREATE INDEX IDX_387590827E734232 ON unique_view (link_view_id)');
        $this->addSql('ALTER TABLE unique_view ADD CONSTRAINT FK_387590827E734232 FOREIGN KEY (link_view_id) REFERENCES link_stat (ulid) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE unique_view DROP CONSTRAINT FK_387590827E734232');
        $this->addSql('DROP TABLE link_stat');
        $this->addSql('DROP TABLE unique_view');
    }
}
