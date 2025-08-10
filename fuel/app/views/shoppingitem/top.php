<h2>◆期限が近いアイテム</h2>
<ul data-bind="foreach: items">
    <li data-bind="css: { done: done() == 1 }">
        <input type="checkbox" data-bind="checked: done, click: toggleDone">
        <span data-bind="text: name"></span>
        (<span data-bind="text: due_date"></span>)
        <button data-bind="click: $parent.editItem">編集</button>
        <button data-bind="click: $parent.deleteItem">削除</button>
    </li>
</ul>

<script>
function ViewModel() {
    var self = this;
    self.items = ko.observableArray(<?php echo json_encode($items); ?>);

    self.toggleDone = function(item) {
        var newDone = item.done() == 1 ? 0 : 1;
        fetch('/api/items/done/' + item.id, {
            method: 'POST',
            body: JSON.stringify({ done: newDone })
        }).then(() => {
            item.done(newDone);
        });
    };

    self.editItem = function(item) {
        location.href = '/items/edit/' + item.id;
    };

    self.deleteItem = function(item) {
        if (confirm('削除してよろしいですか？')) {
            fetch('/items/delete/' + item.id)
            .then(() => self.items.remove(item));
        }
    };
}

ko.applyBindings(new ViewModel());
</script>
