<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20201207190259 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create stories en tags relation table';
    }

    public function up(Schema $schema) : void
    {
        $sql = <<<SQL
            CREATE TABLE `story_tag` (
              `story_id` int unsigned NOT NULL,
              `tag_id` int unsigned NOT NULL,
              UNIQUE KEY `story_tag_unique_combination` (`story_id`,`tag_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
        SQL;

        $this->addSql($sql);
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE `story_tag`');
    }
}
