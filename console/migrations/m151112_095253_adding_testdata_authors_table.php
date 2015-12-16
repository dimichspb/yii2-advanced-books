<?php

use yii\db\Schema;
use yii\db\Migration;

class m151112_095253_adding_testdata_authors_table extends Migration
{
    public function up()
    {
        $this->batchInsert('{{%authors}}', 
            ['firstname', 'lastname'], [

            ['Александр', 'Пушкин'],
            ['Александр', 'Дюма'],
            ['Лев',       'Толстой'],
            ['Геннадий',  'Хазанов'],
            ['Jack',      'London'],
            ['Lewis',     'Carroll'],
            ['Daniel',    'Defoe'],

        ]);
        
    }

    public function down()
    {
        $this->truncateTable('{{%authors}}');
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
