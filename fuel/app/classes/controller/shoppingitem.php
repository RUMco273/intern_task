<?php

use Fuel\Core\Controller_Template;
use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\View;
use Fuel\Core\Security;
use Model\Category;
use Model\Item;


class Controller_ShoppingItem extends Controller_Template
{
    public $template = 'template';

    public function before()
    {
        parent::before();
        $this->template->categories = Category::get_all();
    }

    public function action_top()
    {
        $data['items'] = Item::get_near_due(5);
        $this->template->title = '期限が近いアイテム';
        $this->template->content = View::forge('shoppingitem/top', $data);
    }

    public function action_category($id = null)
    {
        $data['category_name'] = '';
        foreach ($this->template->categories as $cat) {
            if ($cat['id'] === $id) {
                $data['category_name'] = $cat['name'];
                break;
            }
        }
        $data['items'] = Item::get_by_category($id);
        $this->template->title = $data['category_name'];
        $this->template->content = View::forge('shoppingitem/category', $data);
    }

    public function action_create()
    {
        if (Input::method() === 'POST') {
            Item::create(array(
                'category_id' => Input::post('category_id'),
                'name'        => Input::post('name'),
                'num'         => Input::post('num'),
                'done'        => 0,
                'due_date'    => Input::post('due_date'),
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ));
            Session::set_flash('success', 'アイテムを追加しました');
            return Response::redirect('shoppingitem/top');
        }
        $this->template->title = 'アイテム追加';
        $this->template->content = \View::forge('shoppingitem/create', [
            'categories' => $this->template->categories
        ]);
    }

    public function action_edit($id = null)
    {
        $item = Item::get_one($id);
        if (!$item) {
            Session::set_flash('error', 'アイテムが見つかりません');
            return Response::redirect('shoppingitem/top');
        }

        if (Input::method() === 'POST') {
            Item::update_item($id, array(
                'category_id' => Input::post('category_id'),
                'name'        => Input::post('name'),
                'num'         => Input::post('num'),
                'done'        => Input::post('done', 0),
                'due_date'    => Input::post('due_date'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ));
            Session::set_flash('success', 'アイテムを更新しました');
            return Response::redirect('shoppingitem/top');
        }

        $this->template->title = 'アイテム編集';
        $this->template->content = \View::forge('shoppingitem/edit', [
            'item'       => $item,
            'categories' => $this->template->categories
        ]);
    }

    public function action_delete($id = null)
    {
        if ($id) {
            Item::delete_item($id);
            Session::set_flash('success', 'アイテムを削除しました');
        }
        return Response::redirect('shoppingitem/top');
    }
}
