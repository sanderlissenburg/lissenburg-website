<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20201207190248 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create tags table';
    }

    public function up(Schema $schema) : void
    {
        $sql = <<<SQL
            CREATE TABLE `tags` (
              `id` int unsigned NOT NULL AUTO_INCREMENT,
              `label` varchar(255) NOT NULL DEFAULT '',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
        SQL;

        $this->addSql($sql);
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE `tags`');
    }
}
