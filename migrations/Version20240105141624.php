<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240105141624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638FEE6BB66');
        $this->addSql('CREATE TABLE additional_field (id INT AUTO_INCREMENT NOT NULL, contact_id_id INT NOT NULL, field_name VARCHAR(255) NOT NULL, field_value VARCHAR(255) NOT NULL, INDEX IDX_27073E69526E8E58 (contact_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact_history (id INT AUTO_INCREMENT NOT NULL, additional_field_id INT DEFAULT NULL, operation_name VARCHAR(255) NOT NULL, INDEX IDX_BD9551CAFEE6BB66 (additional_field_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE additional_field ADD CONSTRAINT FK_27073E69526E8E58 FOREIGN KEY (contact_id_id) REFERENCES contact (id)');
        $this->addSql('ALTER TABLE contact_history ADD CONSTRAINT FK_BD9551CAFEE6BB66 FOREIGN KEY (additional_field_id) REFERENCES additional_field (id)');
        $this->addSql('DROP TABLE add_field');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('DROP INDEX IDX_4C62E638FEE6BB66 ON contact');
        $this->addSql('ALTER TABLE contact ADD birthday DATE DEFAULT NULL, ADD favourite TINYINT(1) NOT NULL, DROP profile_pic, CHANGE additional_field_id contact_history_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638D9BCDDC5 FOREIGN KEY (contact_history_id) REFERENCES contact_history (id)');
        $this->addSql('CREATE INDEX IDX_4C62E638D9BCDDC5 ON contact (contact_history_id)');
        $this->addSql('ALTER TABLE `group` ADD favourite TINYINT(1) NOT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE group_name name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638D9BCDDC5');
        $this->addSql('CREATE TABLE add_field (id INT AUTO_INCREMENT NOT NULL, field_key VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, field_value VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, headers LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, queue_name VARCHAR(190) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE additional_field DROP FOREIGN KEY FK_27073E69526E8E58');
        $this->addSql('ALTER TABLE contact_history DROP FOREIGN KEY FK_BD9551CAFEE6BB66');
        $this->addSql('DROP TABLE additional_field');
        $this->addSql('DROP TABLE contact_history');
        $this->addSql('DROP INDEX IDX_4C62E638D9BCDDC5 ON contact');
        $this->addSql('ALTER TABLE contact ADD profile_pic VARCHAR(255) NOT NULL, DROP birthday, DROP favourite, CHANGE contact_history_id additional_field_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638FEE6BB66 FOREIGN KEY (additional_field_id) REFERENCES add_field (id)');
        $this->addSql('CREATE INDEX IDX_4C62E638FEE6BB66 ON contact (additional_field_id)');
        $this->addSql('ALTER TABLE `group` DROP favourite, CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE name group_name VARCHAR(255) NOT NULL');
    }
}
