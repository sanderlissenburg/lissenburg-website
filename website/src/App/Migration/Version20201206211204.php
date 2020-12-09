<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

final class Version20201206211204 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create stories table';
    }

    public function up(Schema $schema) : void
    {
        $sql = <<<SQL
            CREATE TABLE `stories` (
              `id` int unsigned NOT NULL AUTO_INCREMENT,
              `title` varchar(255) NOT NULL DEFAULT '',
              `intro` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
              `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
              `created_at` datetime NOT NULL,
              `active` tinyint(1) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
        SQL;

        $this->addSql($sql);
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE `stories`');
    }
}
