<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241226092435 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_variant_options (id INT AUTO_INCREMENT NOT NULL, product_variant_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, INDEX IDX_8D1BD25CA80EF684 (product_variant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_variant_options ADD CONSTRAINT FK_8D1BD25CA80EF684 FOREIGN KEY (product_variant_id) REFERENCES product_variant (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_variant_options DROP FOREIGN KEY FK_8D1BD25CA80EF684');
        $this->addSql('DROP TABLE product_variant_options');
    }
}
