<h2>◆アイテム追加</h2>
<form method="post" onsubmit="return confirmLeave()">
    名前: <input type="text" name="name" required><br>
    個数: <input type="number" name="num" required><br>
    購入期限: <input type="date" name="due_date" required><br>
    カテゴリ:
    <select name="category_id">
        <?php foreach ($categories as $cat): ?>
            <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
        <?php endforeach; ?>
    </select><br>
    <button type="submit">確定</button>
</form>
<script>
let isDirty = true;
window.onbeforeunload = function(){
    if (isDirty) return '入力内容を破棄してよろしいですか？';
};
function confirmLeave(){
    isDirty = false;
    return true;
}
</script>
