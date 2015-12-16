<?php

use yii\db\Schema;
use yii\db\Migration;

class m151112_094309_adding_books_authors_tables extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%authors}}', [
            'id' => $this->primaryKey(),
            'firstname' => $this->string(255)->notNull(),
            'lastname' => $this->string(255)->notNull(),
        ], $tableOptions);

        $this->createTable('{{%books}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'date_create' => $this->integer()->notNull(),
            'date_update' => $this->integer()->notNull(),
            'preview' => $this->string(255),
            'date' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('idx_authors_firstname', '{{%authors}}', 'firstname');
        $this->createIndex('idx_authors_lastname', '{{%authors}}', 'lastname');

        $this->createIndex('idx_books_name', '{{%books}}', 'name');
        $this->createIndex('idx_books_author_id', '{{%books}}', 'author_id');

        $this->addForeignKey('fkey_books_authors_author_id', '{{%books}}', 'author_id', '{{%authors}}', 'id', 'RESTRICT', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%books}}');
        $this->dropTable('{{%authors}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
