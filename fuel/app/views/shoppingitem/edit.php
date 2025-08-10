<h2>◆アイテム編集</h2>
<form method="post" onsubmit="return confirmLeave()">
    名前: <input type="text" name="name" value="<?php echo $item['name']; ?>" required><br>
    個数: <input type="number" name="num" value="<?php echo $item['num']; ?>" required><br>
    購入期限: <input type="date" name="due_date" value="<?php echo $item['due_date']; ?>" required><br>
    カテゴリ:
    <select name="category_id">
        <?php foreach ($categories as $cat): ?>
            <option value="<?php echo $cat['id']; ?>" <?php if($cat['id'] == $item['category_id']) echo 'selected'; ?>>
                <?php echo $cat['name']; ?>
            </option>
        <?php endforeach; ?>
    </select><br>
    購入状態:
    <select name="done">
        <option value="0" <?php if(!$item['done']) echo 'selected'; ?>>未購入</option>
        <option value="1" <?php if($item['done']) echo 'selected'; ?>>購入済</option>
    </select><br>
    <button type="submit">確定</button>
</form>
<script>
let isDirty = true;
window.onbeforeunload = function(){
    if (isDirty) return '編集内容を破棄してよろしいですか？';
};
function confirmLeave(){
    isDirty = false;
    return true;
}
</script>
