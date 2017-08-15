<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170501002314 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sport_types (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, machine_name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');

        $this->addSql("INSERT INTO sport_types (id, name, machine_name) VALUES (1, 'Baseball', 'baseball')");
        $this->addSql("INSERT INTO sport_types (id, name, machine_name) VALUES (2, 'Football', 'football')");
        $this->addSql("INSERT INTO sport_types (id, name, machine_name) VALUES (3, 'Basketball', 'basketball')");
        $this->addSql("INSERT INTO sport_types (id, name, machine_name) VALUES (4, 'Soccer', 'soccer')");
        $this->addSql("INSERT INTO sport_types (id, name, machine_name) VALUES (5, 'Hockey', 'hockey')");
        $this->addSql("INSERT INTO sport_types (id, name, machine_name) VALUES (6, 'Lacrosse', 'lacrosse')");
        $this->addSql("INSERT INTO sport_types (id, name, machine_name) VALUES (7, 'MMA', 'mma')");
        $this->addSql("INSERT INTO sport_types (id, name, machine_name) VALUES (8, 'Golf', 'golf')");
        $this->addSql("INSERT INTO sport_types (id, name, machine_name) VALUES (9, 'Boxing', 'boxing')");
        $this->addSql("INSERT INTO sport_types (id, name, machine_name) VALUES (10, 'Tennis', 'tennis')");
        $this->addSql("INSERT INTO sport_types (id, name, machine_name) VALUES (11, 'Surfing', 'surfing')");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE sport_types');
    }
}
