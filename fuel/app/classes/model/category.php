<?php

namespace Model;

use Fuel\Core\DB;

class Category
{
    public static function get_all()
    {
        return DB::select()->from('category')->execute()->as_array();
    }
}
