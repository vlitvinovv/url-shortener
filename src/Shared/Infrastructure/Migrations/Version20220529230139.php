<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220529230139 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE links_tags (link_ulid VARCHAR(26) NOT NULL, tag_ulid VARCHAR(26) NOT NULL, PRIMARY KEY(link_ulid, tag_ulid))');
        $this->addSql('CREATE INDEX IDX_ED4C7DAE73CF5AF0 ON links_tags (link_ulid)');
        $this->addSql('CREATE INDEX IDX_ED4C7DAE2C8777EF ON links_tags (tag_ulid)');
        $this->addSql('CREATE TABLE tag (ulid VARCHAR(26) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(ulid))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_389B7835E237E06 ON tag (name)');
        $this->addSql('ALTER TABLE links_tags ADD CONSTRAINT FK_ED4C7DAE73CF5AF0 FOREIGN KEY (link_ulid) REFERENCES link (ulid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE links_tags ADD CONSTRAINT FK_ED4C7DAE2C8777EF FOREIGN KEY (tag_ulid) REFERENCES tag (ulid) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE links_tags DROP CONSTRAINT FK_ED4C7DAE2C8777EF');
        $this->addSql('DROP TABLE links_tags');
        $this->addSql('DROP INDEX UNIQ_389B7835E237E06');
        $this->addSql('DROP TABLE tag');
    }
}
