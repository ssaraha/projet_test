<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211102061816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Cretion promos table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ArticeTypes (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Articles (id INT AUTO_INCREMENT NOT NULL, type_article_id INT DEFAULT NULL, designation VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, quantity_available INT NOT NULL, critical_quantity INT NOT NULL, unit_price INT NOT NULL, is_promo TINYINT(1) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_46AB533E6F9750B9 (type_article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promo (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, value DOUBLE PRECISION NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, INDEX IDX_B0139AFB7294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Articles ADD CONSTRAINT FK_46AB533E6F9750B9 FOREIGN KEY (type_article_id) REFERENCES ArticeTypes (id)');
        $this->addSql('ALTER TABLE promo ADD CONSTRAINT FK_B0139AFB7294869C FOREIGN KEY (article_id) REFERENCES Articles (id)');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_type');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Articles DROP FOREIGN KEY FK_46AB533E6F9750B9');
        $this->addSql('ALTER TABLE promo DROP FOREIGN KEY FK_B0139AFB7294869C');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, image VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, quantity_available INT NOT NULL, critical_quantity INT NOT NULL, unit_price INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE article_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE ArticeTypes');
        $this->addSql('DROP TABLE Articles');
        $this->addSql('DROP TABLE promo');
    }
}
