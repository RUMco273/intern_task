<?php

return array(
    // デフォルトルート（トップページ）
    '_root_'  => 'shoppingitem/top',

    // トップページ（期限が近いアイテム）
    'shoppingitem/top' => 'shoppingitem/top',

    // カテゴリ別ページ
	'shoppingitem/category/(:num)' => 'shoppingitem/category/$1',

    // アイテム追加
    'shoppingitem/create' => 'shoppingitem/create',

    // アイテム編集
	'shoppingitem/edit/(:num)' => 'shoppingitem/edit/$1',

    // アイテム削除
    'shoppingitem/delete/(:num)' => 'shoppingitem/delete/$1',

    // APIでdone更新（非同期処理用）
    'api/shoppingitem/done/(:num)' => 'api/shoppingitem/done/$1',

    // 404エラー時
    '_404_'   => 'welcome/404',

    // アイテムの完了状態を切り替える (POSTリクエスト)
    'shoppingitem/toggledone' => 'shoppingitem/toggledone',
);
