<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211112075712 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles ADD details LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE promo RENAME INDEX idx_b0139afb7294869c TO IDX_71D2B5FF7294869C');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Articles DROP details');
        $this->addSql('ALTER TABLE Promo RENAME INDEX idx_71d2b5ff7294869c TO IDX_B0139AFB7294869C');
    }
}
