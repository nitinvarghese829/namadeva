<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240710163446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blogs (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blogs_media (id INT AUTO_INCREMENT NOT NULL, blogs_id INT DEFAULT NULL, original_name VARCHAR(255) NOT NULL, encoded_name VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_7D46BBB989C05BBC (blogs_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blogs_media ADD CONSTRAINT FK_7D46BBB989C05BBC FOREIGN KEY (blogs_id) REFERENCES blogs (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blogs_media DROP FOREIGN KEY FK_7D46BBB989C05BBC');
        $this->addSql('DROP TABLE blogs');
        $this->addSql('DROP TABLE blogs_media');
    }
}
