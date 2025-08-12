<h2>◆アイテム編集</h2>
<form method="post">
    <input type="hidden" name="fuel_csrf_token" value="<?php echo \Security::fetch_token(); ?>">

    <div class="form-group">
        <label for="name">名前</label>
        <input type="text" id="name" name="name" value="<?php echo $item['name']; ?>" required>
    </div>

    <div class="form-group">
        <label for="num">個数</label>
        <input type="number" id="num" name="num" min="1" value="<?php echo $item['num']; ?>" required>
    </div>
    <div class="form-group">
        <label for="due_date">購入期限</label>
        <input type="date" id="due_date" name="due_date" value="<?php echo $item['due_date']; ?>" required>
    </div>

    <div class="form-group">
        <label for="category_id">カテゴリ</label>
        <select id="category_id" name="category_id">
            <?php foreach ($categories as $cat): ?>
                <option value="<?php echo $cat['id']; ?>" <?php if($cat['id'] == $item['category_id']) echo 'selected'; ?>>
                    <?php echo $cat['name']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="done">購入状態</label>
        <select id="done" name="done">
            <option value="0" <?php if(!$item['done']) echo 'selected'; ?>>未購入</option>
            <option value="1" <?php if($item['done']) echo 'selected'; ?>>購入済</option>
        </select>
    </div>
    <button type="submit" class="primary-action">確定</button>
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
