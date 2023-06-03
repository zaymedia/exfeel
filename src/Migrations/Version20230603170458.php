<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230603170458 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE instagram_profile (id BIGINT AUTO_INCREMENT NOT NULL, user_id BIGINT NOT NULL, username VARCHAR(255) NOT NULL, is_free TINYINT(1) NOT NULL, is_private TINYINT(1) NOT NULL, is_verified TINYINT(1) NOT NULL, is_business TINYINT(1) NOT NULL, media_count INT NOT NULL, follower_count INT NOT NULL, following_count INT NOT NULL, biography VARCHAR(255) DEFAULT NULL, photos VARCHAR(255) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, photo_host VARCHAR(255) DEFAULT NULL, photo_file_id VARCHAR(255) DEFAULT NULL, stories_time_start INT NOT NULL, stories_time INT NOT NULL, last_story_id INT DEFAULT NULL, last_story_at INT NOT NULL, count_stories INT NOT NULL, count_posts INT NOT NULL, count_comments INT NOT NULL, not_found_at INT DEFAULT NULL, create_at INT NOT NULL, updated_at INT DEFAULT NULL, deleted_at INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE instagram_stories (id BIGINT AUTO_INCREMENT NOT NULL, user_id BIGINT NOT NULL, story_id VARCHAR(255) NOT NULL, photo VARCHAR(255) DEFAULT NULL, photo_host VARCHAR(255) DEFAULT NULL, photo_file_id VARCHAR(255) DEFAULT NULL, photo_blur VARCHAR(255) DEFAULT NULL, photo_blur_host VARCHAR(255) DEFAULT NULL, photo_blur_file_id VARCHAR(255) DEFAULT NULL, video VARCHAR(255) DEFAULT NULL, video_host VARCHAR(255) DEFAULT NULL, video_file_id VARCHAR(255) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, taken_at INT NOT NULL, create_at INT NOT NULL, updated_at INT DEFAULT NULL, deleted_at INT DEFAULT NULL, UNIQUE INDEX UNIQ_11941251AA5D4036 (story_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oauth_auth_codes (identifier VARCHAR(80) NOT NULL, expiry_date_time DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', user_identifier CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', PRIMARY KEY(identifier)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oauth_refresh_tokens (identifier VARCHAR(80) NOT NULL, expiry_date_time DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', user_identifier INT NOT NULL, locale VARCHAR(255) DEFAULT NULL, push_token VARCHAR(255) DEFAULT NULL, voip_token VARCHAR(255) DEFAULT NULL, base_os VARCHAR(255) DEFAULT NULL, build_id VARCHAR(255) DEFAULT NULL, brand VARCHAR(255) DEFAULT NULL, build_number VARCHAR(255) DEFAULT NULL, bundle_id VARCHAR(255) DEFAULT NULL, carrier VARCHAR(255) DEFAULT NULL, device_id VARCHAR(255) DEFAULT NULL, device_name VARCHAR(255) DEFAULT NULL, ip_address VARCHAR(255) DEFAULT NULL, installer_package_name VARCHAR(255) DEFAULT NULL, mac_address VARCHAR(255) DEFAULT NULL, manufacturer VARCHAR(255) DEFAULT NULL, model VARCHAR(255) DEFAULT NULL, system_name VARCHAR(255) DEFAULT NULL, system_version VARCHAR(255) DEFAULT NULL, user_agent VARCHAR(255) DEFAULT NULL, version VARCHAR(255) DEFAULT NULL, created_at INT DEFAULT 0 NOT NULL, INDEX IDX_SEARCH (identifier), INDEX IDX_USER_ID (user_identifier), INDEX IDX_PUSH_TOKEN (push_token), PRIMARY KEY(identifier)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT UNSIGNED AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE instagram_profile');
        $this->addSql('DROP TABLE instagram_stories');
        $this->addSql('DROP TABLE oauth_auth_codes');
        $this->addSql('DROP TABLE oauth_refresh_tokens');
        $this->addSql('DROP TABLE users');
    }
}
