<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240910081335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog_post_media (id INT AUTO_INCREMENT NOT NULL, blog_post_id INT DEFAULT NULL, original_name VARCHAR(255) DEFAULT NULL, encoded_name VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_1BF10F0AA77FBEAF (blog_post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog_post_media ADD CONSTRAINT FK_1BF10F0AA77FBEAF FOREIGN KEY (blog_post_id) REFERENCES blog_post (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog_post_media DROP FOREIGN KEY FK_1BF10F0AA77FBEAF');
        $this->addSql('DROP TABLE blog_post_media');
        $this->addSql('ALTER TABLE blog_post ADD original_name VARCHAR(255) NOT NULL, ADD encoded_name VARCHAR(255) NOT NULL, ADD image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE enquiry CHANGE firstname firstname VARCHAR(255) DEFAULT NULL, CHANGE lastname lastname VARCHAR(255) DEFAULT NULL, CHANGE phone phone VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE pincode pincode VARCHAR(10) DEFAULT NULL');
    }
}
