<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200517180547 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add admin user ';
    }

    public function up(Schema $schema) : void
    {
        $sql = 'INSERT INTO `user` (`email`, `roles`, `password`, `first_name`, `last_name`, `active`) VALUES (\'sanderlissenburg@gmail.com\', \'["ROLE_ADIM"]\', \'$argon2id$v=19$m=65536,t=4,p=1$B2SEoDYIOTn7xFCHRG25kA$KbkQbS3NhXgegfRNy4dXx5TXxHyi9baXDFjvMVm0i8\', \'Sander\', \'Lissenburg\', 1);';

        $this->addSql($sql);
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
