<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260424073407 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Supprimer les contraintes UNIQUE sur name et importance pour permettre à chaque utilisateur d\'avoir ses propres priorités';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__priority AS SELECT id, name, importance, color, user_id FROM priority');
        $this->addSql('DROP TABLE priority');
        $this->addSql('CREATE TABLE priority (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, importance INTEGER NOT NULL, color VARCHAR(7) DEFAULT NULL, user_id INTEGER DEFAULT NULL, CONSTRAINT FK_62A6DC27A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO priority (id, name, importance, color, user_id) SELECT id, name, importance, color, user_id FROM __temp__priority');
        $this->addSql('DROP TABLE __temp__priority');
        $this->addSql('CREATE INDEX IDX_62A6DC27A76ED395 ON priority (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__priority AS SELECT id, name, importance, color, user_id FROM priority');
        $this->addSql('DROP TABLE priority');
        $this->addSql('CREATE TABLE priority (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, importance INTEGER NOT NULL, color VARCHAR(7) DEFAULT NULL, user_id INTEGER DEFAULT NULL, CONSTRAINT FK_62A6DC27A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO priority (id, name, importance, color, user_id) SELECT id, name, importance, color, user_id FROM __temp__priority');
        $this->addSql('DROP TABLE __temp__priority');
        $this->addSql('CREATE INDEX IDX_62A6DC27A76ED395 ON priority (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_62A6DC275E237E06 ON priority (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_62A6DC274A99BD99 ON priority (importance)');
    }
}
