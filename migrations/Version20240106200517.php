<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240106200517 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE additional_field (id INT AUTO_INCREMENT NOT NULL, contact_id INT NOT NULL, contact_history_id INT DEFAULT NULL, field_name VARCHAR(255) NOT NULL, field_value LONGTEXT NOT NULL, INDEX IDX_27073E69E7A1254A (contact_id), INDEX IDX_27073E69D9BCDDC5 (contact_history_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, group_id_id INT DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, birthdate VARCHAR(255) DEFAULT NULL, is_favorite TINYINT(1) NOT NULL, INDEX IDX_4C62E6382F68B530 (group_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact_history (id INT AUTO_INCREMENT NOT NULL, contact_id INT NOT NULL, operation_name VARCHAR(255) NOT NULL, timestamp DATETIME NOT NULL, INDEX IDX_BD9551CAE7A1254A (contact_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, color VARCHAR(255) NOT NULL, is_favorite TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE additional_field ADD CONSTRAINT FK_27073E69E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id)');
        $this->addSql('ALTER TABLE additional_field ADD CONSTRAINT FK_27073E69D9BCDDC5 FOREIGN KEY (contact_history_id) REFERENCES contact_history (id)');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E6382F68B530 FOREIGN KEY (group_id_id) REFERENCES `group` (id)');
        $this->addSql('ALTER TABLE contact_history ADD CONSTRAINT FK_BD9551CAE7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE additional_field DROP FOREIGN KEY FK_27073E69E7A1254A');
        $this->addSql('ALTER TABLE additional_field DROP FOREIGN KEY FK_27073E69D9BCDDC5');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E6382F68B530');
        $this->addSql('ALTER TABLE contact_history DROP FOREIGN KEY FK_BD9551CAE7A1254A');
        $this->addSql('DROP TABLE additional_field');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE contact_history');
        $this->addSql('DROP TABLE `group`');
    }
}
