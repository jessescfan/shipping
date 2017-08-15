<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170428045123 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE bets (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, amount INT DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, currency VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_bets (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, bet_id INT DEFAULT NULL, selection VARCHAR(255) DEFAULT NULL, INDEX IDX_6A939E2A76ED395 (user_id), INDEX IDX_6A939E2D871DC26 (bet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_bets ADD CONSTRAINT FK_6A939E2A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE user_bets ADD CONSTRAINT FK_6A939E2D871DC26 FOREIGN KEY (bet_id) REFERENCES bets (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_bets DROP FOREIGN KEY FK_6A939E2D871DC26');
        $this->addSql('DROP TABLE bets');
        $this->addSql('DROP TABLE user_bets');
    }
}
