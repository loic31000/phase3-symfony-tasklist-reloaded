<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260423094606 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE test');
        $this->addSql('CREATE TEMPORARY TABLE __temp__priority AS SELECT id, name, importance FROM priority');
        $this->addSql('DROP TABLE priority');
        $this->addSql('CREATE TABLE priority (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, importance INTEGER NOT NULL, color VARCHAR(7) DEFAULT NULL, user_id INTEGER DEFAULT NULL, CONSTRAINT FK_62A6DC27A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO priority (id, name, importance) SELECT id, name, importance FROM __temp__priority');
        $this->addSql('DROP TABLE __temp__priority');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_62A6DC274A99BD99 ON priority (importance)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_62A6DC275E237E06 ON priority (name)');
        $this->addSql('CREATE INDEX IDX_62A6DC27A76ED395 ON priority (user_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__task AS SELECT id, title, status, is_pinned, priority_id, folder_id FROM task');
        $this->addSql('DROP TABLE task');
        $this->addSql('CREATE TABLE task (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, is_pinned BOOLEAN NOT NULL, priority_id INTEGER DEFAULT NULL, folder_id INTEGER DEFAULT NULL, user_id INTEGER DEFAULT NULL, CONSTRAINT FK_527EDB25497B19F9 FOREIGN KEY (priority_id) REFERENCES priority (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_527EDB25162CB942 FOREIGN KEY (folder_id) REFERENCES folder (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_527EDB25A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO task (id, title, status, is_pinned, priority_id, folder_id) SELECT id, title, status, is_pinned, priority_id, folder_id FROM __temp__task');
        $this->addSql('DROP TABLE __temp__task');
        $this->addSql('CREATE INDEX IDX_527EDB25162CB942 ON task (folder_id)');
        $this->addSql('CREATE INDEX IDX_527EDB25497B19F9 ON task (priority_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_527EDB252B36786B ON task (title)');
        $this->addSql('CREATE INDEX IDX_527EDB25A76ED395 ON task (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE test (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name CLOB NOT NULL COLLATE "BINARY", help VARCHAR(255) NOT NULL COLLATE "BINARY", oneto_many VARCHAR(255) DEFAULT NULL COLLATE "BINARY", return VARCHAR(255) NOT NULL COLLATE "BINARY")');
        $this->addSql('CREATE TEMPORARY TABLE __temp__priority AS SELECT id, name, importance FROM priority');
        $this->addSql('DROP TABLE priority');
        $this->addSql('CREATE TABLE priority (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, importance INTEGER NOT NULL)');
        $this->addSql('INSERT INTO priority (id, name, importance) SELECT id, name, importance FROM __temp__priority');
        $this->addSql('DROP TABLE __temp__priority');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_62A6DC275E237E06 ON priority (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_62A6DC274A99BD99 ON priority (importance)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__task AS SELECT id, title, status, is_pinned, priority_id, folder_id FROM task');
        $this->addSql('DROP TABLE task');
        $this->addSql('CREATE TABLE task (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, is_pinned BOOLEAN NOT NULL, priority_id INTEGER DEFAULT NULL, folder_id INTEGER DEFAULT NULL, CONSTRAINT FK_527EDB25497B19F9 FOREIGN KEY (priority_id) REFERENCES priority (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_527EDB25162CB942 FOREIGN KEY (folder_id) REFERENCES folder (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO task (id, title, status, is_pinned, priority_id, folder_id) SELECT id, title, status, is_pinned, priority_id, folder_id FROM __temp__task');
        $this->addSql('DROP TABLE __temp__task');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_527EDB252B36786B ON task (title)');
        $this->addSql('CREATE INDEX IDX_527EDB25497B19F9 ON task (priority_id)');
        $this->addSql('CREATE INDEX IDX_527EDB25162CB942 ON task (folder_id)');
    }
}
