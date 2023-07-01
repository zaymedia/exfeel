<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230701120246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD driver VARCHAR(255) DEFAULT NULL, ADD driver_user_id VARCHAR(255) DEFAULT NULL, ADD username VARCHAR(255) DEFAULT NULL, ADD first_name VARCHAR(255) DEFAULT NULL, ADD last_name VARCHAR(255) DEFAULT NULL, ADD language VARCHAR(255) DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_DRIVER ON user (driver, driver_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_DRIVER ON user');
        $this->addSql('ALTER TABLE user DROP driver, DROP driver_user_id, DROP username, DROP first_name, DROP last_name, DROP language');
    }
}
