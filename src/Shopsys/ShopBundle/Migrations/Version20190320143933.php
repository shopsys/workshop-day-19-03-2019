<?php

namespace Shopsys\ShopBundle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Shopsys\MigrationBundle\Component\Doctrine\Migrations\AbstractMigration;

class Version20190320143933 extends AbstractMigration
{
    /**
     * @param \Doctrine\DBAL\Schema\Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->sql('CREATE TABLE static_blocks (id SERIAL NOT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->sql('CREATE UNIQUE INDEX UNIQ_45E8BD7B77153098 ON static_blocks (code)');
        $this->sql('
            CREATE TABLE static_blocks_translations (
                id SERIAL NOT NULL,
                translatable_id INT NOT NULL,
                text TEXT NOT NULL,
                locale VARCHAR(255) NOT NULL,
                PRIMARY KEY(id)
            )');
        $this->sql('CREATE INDEX IDX_CEF5AD052C2AC5D3 ON static_blocks_translations (translatable_id)');
        $this->sql('
            CREATE UNIQUE INDEX static_blocks_translations_uniq_trans ON static_blocks_translations (translatable_id, locale)');
        $this->sql('
            ALTER TABLE
                static_blocks_translations
            ADD
                CONSTRAINT FK_CEF5AD052C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES static_blocks (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param \Doctrine\DBAL\Schema\Schema $schema
     */
    public function down(Schema $schema)
    {
    }
}
