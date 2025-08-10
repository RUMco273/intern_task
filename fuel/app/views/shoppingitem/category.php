<h2>◆<?php echo $category_name; ?></h2>
<button onclick="location.href='/shoppingitem/create'">追加</button>
<ul>
<?php foreach ($items as $item): ?>
    <li class="<?php echo $item['done'] ? 'done' : ''; ?>">
        <input type="checkbox" <?php echo $item['done'] ? 'checked' : ''; ?>>
        <?php echo $item['name']; ?> 個数:<?php echo $item['num']; ?> <?php echo $item['due_date']; ?>
        <button onclick="location.href='/shoppingitem/edit/<?php echo $item['id']; ?>'">編集</button>
        <button onclick="if(confirm('削除しますか？')) location.href='/shoppingitem/delete/<?php echo $item['id']; ?>'">削除</button>
    </li>
<?php endforeach; ?>
</ul>
