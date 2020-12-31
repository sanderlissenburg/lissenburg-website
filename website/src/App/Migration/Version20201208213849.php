<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20201208213849 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $sql = <<<SQL
            ALTER TABLE `stories` ADD `type` ENUM("short", "long")
            NOT NULL
            DEFAULT 'short'
            AFTER `id`
        SQL;

        $this->addSql($sql);
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE `stories` DROP `type`');
    }
}
