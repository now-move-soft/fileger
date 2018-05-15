<?php

use nms\fileger\Module;
use yii\db\Migration;

/**
 * Class m180515_023156_init
 * 
 * @author Michael Naumov <vommuan@gmail.com>
 * @copyright 2018 Now Move Soft
 * @since v0.1
 */
class m180515_023156_init extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('{{%fm_file}}', [
            'id' => $this->primaryKey(),
            'url' => $this->text()->notNull(),
            'type' => $this->string()->notNull(), // MIME-type
            'size' => $this->string()->notNull(), // file size
            'name' => $this->string(), // user frendly file name
            'description' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(), // without foreign key to users table
            'updated_by' => $this->integer(),
        ], $tableOptions);
        
        $this->createTable('{{%fm_tag}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(), // without foreign key to users table
            'updated_by' => $this->integer(),
        ], $tableOptions);
        
        $this->createTable('{{%fm_file_tag}}', [
            'id' => $this->primaryKey(),
            'file_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
        
        $this->addForeignKey('fk_fm_file_tag_file_id', '{{%fm_file_tag}}', 'file_id', '{{%fm_file}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_fm_file_tag_tag_id', '{{%fm_file_tag}}', 'tag_id', '{{%fm_tag}}', 'id', 'CASCADE', 'CASCADE');
        
        $this->createTable('{{%fm_thumbnail_alias}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string()->notNull()->unique(),
            'width' => $this->integer()->notNull(),
            'height' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(), // without foreign key to users table
            'updated_by' => $this->integer(),
        ], $tableOptions);
        
        // Default thumbnail alias
        $this->insert('{{%fm_thumbnail_alias}}', [
            'slug' => 'default',
            'width' => 200,
            'height' => 200,
            'created_at' => time(),
        ]);
        
        $this->createTable('{{%fm_thumbnail}}', [
            'id' => $this->primaryKey(),
            'url' => $this->text()->notNull(),
            'file_id' => $this->integer()->notNull(),
            'alias_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
        
        $this->addForeignKey('fk_fm_thumbnail_file_id', '{{%fm_thumbnail}}', 'file_id', '{{%fm_file}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_fm_thumbnail_alias_id', '{{%fm_thumbnail}}', 'alias_id', '{{%fm_thumbnail_alias}}', 'id', 'CASCADE', 'CASCADE');
        
        $this->createTable('{{%fm_setting}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'value' => $this->text()->notNull(),
        ]);

    }
    
    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%fm_setting}}');
        $this->dropTable('{{%fm_thumbnail}}');
        $this->dropTable('{{%fm_thumbnail_alias}}');
        $this->dropTable('{{%fm_file_tag}}');
        $this->dropTable('{{%fm_tag}}');
        $this->dropTable('{{%fm_file}}');
    }
}
