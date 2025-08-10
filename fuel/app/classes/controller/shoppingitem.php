<?php


use Fuel\Core\Controller_Template;
use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Model\Category;
use Model\Item;

class Controller_Shoppingitem extends Controller_Template
{
    public $template = 'template';

    public function before()
    {
        parent::before();
        $this->template->categories = Category::get_all();
    }

    public function action_index()
    {
        $data['items'] = Item::get_all();
        $this->template->title = 'アイテム一覧';
        $this->template->content = \View::forge('items/index', $data);
    }

    public function action_create()
    {
        if (Input::method() == 'POST') {
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
            return Response::redirect('items');
        }
        $this->template->title = 'アイテム追加';
        $this->template->content = \View::forge('items/create');
    }

    public function action_edit($id = null)
    {
        $item = Item::get_one($id);
        if (!$item) {
            Session::set_flash('error', 'アイテムが見つかりません');
            return Response::redirect('items');
        }

        if (Input::method() == 'POST') {
            Item::update_item($id, array(
                'category_id' => Input::post('category_id'),
                'name'        => Input::post('name'),
                'num'         => Input::post('num'),
                'done'        => Input::post('done', 0),
                'due_date'    => Input::post('due_date'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ));
            Session::set_flash('success', 'アイテムを更新しました');
            return Response::redirect('items');
        }

        $this->template->title = 'アイテム編集';
        $this->template->content = \View::forge('items/edit', ['item' => $item]);
    }

    public function action_delete($id = null)
    {
        if ($id) {
            Item::delete_item($id);
            Session::set_flash('success', 'アイテムを削除しました');
        }
        return Response::redirect('items');
    }
}
