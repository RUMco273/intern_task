<?php

use Fuel\Core\Controller_Rest;
use Fuel\Core\Input;
use Model\Item; // 既存のItemモデルを使用

class Controller_Api_Shoppingitem extends Controller_Rest
{
    /**
     * GET /api/shoppingitem/items/{category_id}
     * カテゴリに属するアイテム一覧をJSONで返す
     */
    public function get_items($category_id = null)
    {
        if (empty($category_id)) {
            return $this->response(['error' => 'Category ID is required'], 400);
        }

        $items = Item::get_by_category($category_id);

        // 配列でなかった場合やエラーの場合の処理（必要に応じて）
        if (!is_array($items)) {
            $items = [];
        }
        
        return $this->response($items);
    }

    /**
     * POST /api/shoppingitem/update_done
     * アイテムの完了ステータス(done)を更新する
     */
    public function post_update_done()
    {
        $id = Input::json('id');
        $done = Input::json('done');

        if ($id === null || !in_array($done, [0, 1], true)) {
            return $this->response(['status' => 'error', 'message' => 'Invalid input.'], 400);
        }

        try {
            // 既存のupdate_itemメソッドを利用してdoneとupdated_atを更新
            Item::update_item($id, [
                'done'       => (int)$done,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            return $this->response(['status' => 'success']);

        } catch (\Exception $e) {
            return $this->response(['status' => 'error', 'message' => 'Database update failed.'], 500);
        }
    }
}