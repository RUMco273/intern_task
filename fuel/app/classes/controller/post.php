<?php

class Controller_Post extends Controller{
    public function action_index(){
        $data = array();
        $data['rows'] = Model_Post::find_all();

        return View::forge('shopping/list')
    }
}