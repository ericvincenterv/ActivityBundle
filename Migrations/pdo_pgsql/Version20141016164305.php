<?php

namespace Innova\ActivityBundle\Migrations\pdo_pgsql;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2014/10/16 04:43:07
 */
class Version20141016164305 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE innova_activitySequence (
                id SERIAL NOT NULL, 
                description TEXT DEFAULT NULL, 
                resourceNode_id INT DEFAULT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            CREATE UNIQUE INDEX UNIQ_D614C342B87FAB32 ON innova_activitySequence (resourceNode_id)
        ");
        $this->addSql("
            CREATE TABLE innova_activity (
                id SERIAL NOT NULL, 
                name VARCHAR(255) NOT NULL, 
                description TEXT DEFAULT NULL, 
                activity_order INT NOT NULL, 
                activitySequence_id INT DEFAULT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            CREATE INDEX IDX_4605013F28CE5809 ON innova_activity (activitySequence_id)
        ");
        $this->addSql("
            ALTER TABLE innova_activitySequence 
            ADD CONSTRAINT FK_D614C342B87FAB32 FOREIGN KEY (resourceNode_id) 
            REFERENCES claro_resource_node (id) 
            ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        ");
        $this->addSql("
            ALTER TABLE innova_activity 
            ADD CONSTRAINT FK_4605013F28CE5809 FOREIGN KEY (activitySequence_id) 
            REFERENCES innova_activitySequence (id) 
            ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE innova_activity 
            DROP CONSTRAINT FK_4605013F28CE5809
        ");
        $this->addSql("
            DROP TABLE innova_activitySequence
        ");
        $this->addSql("
            DROP TABLE innova_activity
        ");
    }
}