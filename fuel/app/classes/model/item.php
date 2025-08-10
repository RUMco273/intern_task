<?php

namespace Model;

use Fuel\Core\DB;

class Item
{
    public static function get_all()
    {
        return DB::select()->from('items')->execute()->as_array();
    }

    public static function get_by_category($category_id)
    {
        return DB::select()->from('items')
            ->where('category_id', $category_id)
            ->order_by('due_date', 'asc')
            ->execute()->as_array();
    }

    public static function get_near_due($limit = 5)
    {
        return DB::select()->from('items')
            ->order_by('due_date', 'asc')
            ->limit($limit)
            ->execute()->as_array();
    }

    public static function get_one($id)
    {
        return DB::select()->from('items')->where('id', $id)->execute()->current();
    }

    public static function create($data)
    {
        return DB::insert('items')->set($data)->execute();
    }

    public static function update_item($id, $data)
    {
        return DB::update('items')->set($data)->where('id', $id)->execute();
    }

    public static function delete_item($id)
    {
        return DB::delete('items')->where('id', $id)->execute();
    }
}
