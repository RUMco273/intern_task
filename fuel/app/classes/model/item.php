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

    public static function get_near_due($limit_per_category = 5)
{
    $result = [];

    // 全カテゴリ取得
    $categories = \Model\Category::get_all();

    foreach ($categories as $cat) {
        $items = DB::select()
            ->from('items')
            ->where('category_id', $cat['id'])
            ->where('done', 0) // 未購入のみ
            ->order_by('due_date', 'asc')
            ->limit($limit_per_category)
            ->execute()
            ->as_array();

        $result = array_merge($result, $items);
    }

    // 全カテゴリから集めたものを、期限が近い順に再ソート
    usort($result, function($a, $b) {
        return strcmp($a['due_date'], $b['due_date']);
    });

    return $result;
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
