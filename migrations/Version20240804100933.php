<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240804100933 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_application (product_id INT NOT NULL, application_id INT NOT NULL, INDEX IDX_87443DE4584665A (product_id), INDEX IDX_87443DE3E030ACD (application_id), PRIMARY KEY(product_id, application_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_application ADD CONSTRAINT FK_87443DE4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_application ADD CONSTRAINT FK_87443DE3E030ACD FOREIGN KEY (application_id) REFERENCES application (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_application DROP FOREIGN KEY FK_87443DE4584665A');
        $this->addSql('ALTER TABLE product_application DROP FOREIGN KEY FK_87443DE3E030ACD');
        $this->addSql('DROP TABLE product_application');
    }
}
