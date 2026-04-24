<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260423143313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Mise à jour des statuts de tâches : pending -> en_cours, completed -> terminee';
    }

    public function up(Schema $schema): void
    {
        // Convertir les anciens statuts vers les nouveaux
        $this->addSql("UPDATE task SET status = 'en_cours' WHERE status = 'pending'");
        $this->addSql("UPDATE task SET status = 'terminee' WHERE status = 'completed'");
    }

    public function down(Schema $schema): void
    {
        // Reconvertir vers les anciens statuts
        $this->addSql("UPDATE task SET status = 'pending' WHERE status = 'en_cours'");
        $this->addSql("UPDATE task SET status = 'completed' WHERE status = 'terminee'");
    }
}
