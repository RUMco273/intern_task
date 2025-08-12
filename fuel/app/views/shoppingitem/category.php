<h2>◆<?php echo $category_name; ?></h2>
<script type="text/javascript">
    var initialItems = <?php echo json_encode($items); ?>;
</script>

<button data-bind="click: toggleShowCompleted, text: showCompletedText" style="margin-bottom: 15px;"></button>
<h2 data-bind="if: items().length == 0" style="color: gray;">アイテムはありません。</h2>

<ul data-bind="foreach: filteredItems">
    <li data-bind="css: { done: done() }">
    <input type="checkbox" data-bind="checked: done">
    <span class="item-name" data-bind="text: name"></span>
    <span class="item-details">
        (個数: <span data-bind="text: num"></span>)
        <span data-bind="text: due_date"></span>
    </span>
    <div class="item-actions">
        <button data-bind="click: $parent.editItem">✏️</button>
        <button data-bind="click: $parent.removeItem">🗑️</button>
    </div>
</li>
</ul>
<button class="primary-action btn-add" onclick="location.href='/shoppingitem/create'">追加</button>
<script>
function AppViewModel() {
    var self = this;

    // アイテムのオブジェクトを生成する内部関数
    function ItemViewModel(item) {
        var self_item = this;
        self_item.id = ko.observable(item.id);
        self_item.name = ko.observable(item.name);
        self_item.num = ko.observable(item.num);
        self_item.due_date = ko.observable(item.due_date);
        
        // doneプロパティをobservableにし、値が0か1になるようにする
        self_item.done = ko.observable(item.done == 1); 

        // doneの状態が変更されたら(チェックボックスがクリックされたら)発動
        self_item.done.subscribe(function(newValue) {
            // サーバに非同期で更新リクエストを送信
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // サーバに非同期で更新リクエストを送信
            fetch('/shoppingitem/toggledone', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new URLSearchParams({
                    // 取得したトークンを一緒に送信する
                    'fuel_csrf_token': csrfToken, 
                    'id': self_item.id(),
                    'done': newValue ? 1 : 0
                })
            })
            .then(response => {
                if (!response.ok) { throw new Error('Network response was not ok'); }
                return response.json();
            })
            .then(data => {
                if (data.status === 'ok') {
                    // サーバーから受け取った新しいトークンでmetaタグを更新する
                    if (data.new_token) {
                        document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.new_token);
                    }
                } else {
                    alert('更新に失敗しました。');
                    self_item.done(!newValue); 
                }
            })
        });
    }

    // 初期データを元にItemViewModelの配列を作成
    self.items = ko.observableArray(ko.utils.arrayMap(initialItems, function(item) {
        return new ItemViewModel(item);
    }));

    // 1. 購入済みアイテムの表示状態を管理 (初期値: false)
    self.showCompleted = ko.observable(false);

    // 2. 表示状態に応じてリストをフィルタリングする「算出プロパティ」
    self.filteredItems = ko.computed(function() {
        if (!self.showCompleted()) {
            // "showCompleted"がfalseなら、"done"がfalseのアイテムだけを返す
            return ko.utils.arrayFilter(self.items(), function(item) {
                return !item.done();
            });
        } else {
            // "showCompleted"がtrueなら、全アイテムをそのまま返す
            return self.items();
        }
    });

    // ボタンのテキストを動的に変更するための算出プロパティ
    self.showCompletedText = ko.computed(function() {
        return self.showCompleted() ? '購入した商品を隠す' : '購入した商品を表示';
    });

    // ボタンがクリックされたときに"showCompleted"の状態を反転させる関数
    self.toggleShowCompleted = function() {
        self.showCompleted(!self.showCompleted());
    };

    self.editItem = function(item) {
        location.href = '/shoppingitem/edit/' + item.id();
    };

    self.removeItem = function(item) {
        if (confirm('本当に削除しますか？')) {
            // 現在のCSRFトークンを取得
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('/shoppingitem/delete/' + item.id(), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            // bodyにCSRFトークンを含める
            body: new URLSearchParams({
                'fuel_csrf_token': csrfToken
            })
        })
        .then(response => {
            if (!response.ok) { throw new Error('Network response was not ok'); }
            return response.json();
        })
        .then(data => {
            if (data.status === 'ok') {
                // 成功したら画面からアイテムを削除
                self.items.remove(item);
                // 新しいトークンでmetaタグを更新
                if (data.new_token) {
                    document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.new_token);
                }
            } else {
                alert('削除に失敗しました。');
            }
        })
        .catch(error => {
            console.error('Fetch Error:', error);
            alert('サーバーとの通信中にエラーが発生しました。');
        });
        }
    };
}

ko.applyBindings(new AppViewModel());
</script>
