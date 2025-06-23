<?php

// fuel/app/classes/controller/shopping.php
class Controller_Shopping extends Controller
{
    public function action_index()
    {
        return View::forge('shopping/shopping_view_index', [
    'username' => 'タカノさん'
]);
    }

    public function action_food(){
        return View::forge('shopping/shopping_view_food');
    }
}

