<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20201209092451 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $sql = <<<SQL
            ALTER TABLE `stories` ADD `slug` VARCHAR (255)
            AFTER `title`
        SQL;

        $this->addSql($sql);    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE `stories` DROP `slug`');
    }
}
