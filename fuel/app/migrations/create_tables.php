<?php

namespace Fuel\Migrations;

class Create_tables
{
    public function up()
    {
        \DBUtil::create_table('category', array(
            'id'   => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
            'name' => array('type' => 'varchar', 'constraint' => 50, 'null' => false),
        ), array('id'));

        \DBUtil::create_table('items', array(
            'id'          => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
            'category_id' => array('type' => 'int', 'constraint' => 11, 'null' => false),
            'name'        => array('type' => 'varchar', 'constraint' => 50, 'null' => false),
            'num'         => array('type' => 'int', 'constraint' => 11, 'null' => false),
            'done'        => array('type' => 'int', 'constraint' => 1, 'default' => 0),
            'due_date'    => array('type' => 'date', 'null' => false),
            'created_at'  => array('type' => 'datetime', 'null' => false),
            'updated_at'  => array('type' => 'datetime', 'null' => false),
        ), array('id'));

        // 外部キー追加
        \DB::query("ALTER TABLE items ADD CONSTRAINT fk_items_category FOREIGN KEY (category_id) REFERENCES category(id)")->execute();
    }

    public function down()
    {
        \DBUtil::drop_table('items');
        \DBUtil::drop_table('category');
    }
}
