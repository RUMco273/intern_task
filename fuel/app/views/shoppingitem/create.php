<h2>◆アイテム追加</h2>

<form method="post" onsubmit="return confirmLeave()">
    <input type="hidden" name="fuel_csrf_token" value="<?php echo \Security::fetch_token(); ?>">
    <div class="form-group">
        <label for="name">名前</label>
        <input type="text" id="name" name="name" required>
    </div>
    <div class="form-group">
        <label for="num">個数</label>
        <input type="number" id="num" name="num" min="1" value="1" required>
    </div>
    <div class="form-group">
        <label for="due_date">購入期限</label>
        <input type="date" id="due_date" name="due_date" required>
    </div>
    <div class="form-group">
        カテゴリ
    <select name="category_id">
        <?php foreach ($categories as $cat): ?>
            <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
        <?php endforeach; ?>
    </select><br>
    </div>
    <button type="submit" class="primary-action">確定</button>
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
