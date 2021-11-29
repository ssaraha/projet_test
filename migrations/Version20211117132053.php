<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211117132053 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sale_detail ADD slae_id INT DEFAULT NULL, ADD article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sale_detail ADD CONSTRAINT FK_5A677151E709F07 FOREIGN KEY (slae_id) REFERENCES sale (id)');
        $this->addSql('ALTER TABLE sale_detail ADD CONSTRAINT FK_5A6771517294869C FOREIGN KEY (article_id) REFERENCES Articles (id)');
        $this->addSql('CREATE INDEX IDX_5A677151E709F07 ON sale_detail (slae_id)');
        $this->addSql('CREATE INDEX IDX_5A6771517294869C ON sale_detail (article_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sale_detail DROP FOREIGN KEY FK_5A677151E709F07');
        $this->addSql('ALTER TABLE sale_detail DROP FOREIGN KEY FK_5A6771517294869C');
        $this->addSql('DROP INDEX IDX_5A677151E709F07 ON sale_detail');
        $this->addSql('DROP INDEX IDX_5A6771517294869C ON sale_detail');
        $this->addSql('ALTER TABLE sale_detail DROP slae_id, DROP article_id');
    }
}
