<?php

namespace Innova\ActivityBundle\Migrations\sqlsrv;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2014/12/03 11:15:51
 */
class Version20141203111550 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE innova_activity_type_available_activity (
                activity_id INT NOT NULL, 
                type_id INT NOT NULL, 
                PRIMARY KEY (activity_id, type_id)
            )
        ");
        $this->addSql("
            CREATE INDEX IDX_BD23E5281C06096 ON innova_activity_type_available_activity (activity_id)
        ");
        $this->addSql("
            CREATE UNIQUE INDEX UNIQ_BD23E52C54C8C93 ON innova_activity_type_available_activity (type_id) 
            WHERE type_id IS NOT NULL
        ");
        $this->addSql("
            CREATE TABLE innova_activity_type_available (
                id INT IDENTITY NOT NULL, 
                name NVARCHAR(255) NOT NULL, 
                class NVARCHAR(100) NOT NULL, 
                PRIMARY KEY (id)
            )
        ");
        $this->addSql("
            ALTER TABLE innova_activity_type_available_activity 
            ADD CONSTRAINT FK_BD23E5281C06096 FOREIGN KEY (activity_id) 
            REFERENCES innova_activity (id)
        ");
        $this->addSql("
            ALTER TABLE innova_activity_type_available_activity 
            ADD CONSTRAINT FK_BD23E52C54C8C93 FOREIGN KEY (type_id) 
            REFERENCES innova_activity_type_available (id)
        ");
        $this->addSql("
            ALTER TABLE innova_activity 
            DROP COLUMN class
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE innova_activity_type_available_activity 
            DROP CONSTRAINT FK_BD23E52C54C8C93
        ");
        $this->addSql("
            DROP TABLE innova_activity_type_available_activity
        ");
        $this->addSql("
            DROP TABLE innova_activity_type_available
        ");
        $this->addSql("
            ALTER TABLE innova_activity 
            ADD class NVARCHAR(255) NOT NULL
        ");
    }
}