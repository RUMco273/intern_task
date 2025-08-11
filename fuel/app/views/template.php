<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="csrf-token" content="<?php echo \Security::fetch_token(); ?>">
<title><?php echo $title; ?></title>
<script src="https://cdn.jsdelivr.net/npm/knockout@3.5.1/build/output/knockout-latest.js"></script>
<style>
    body { font-family: sans-serif; margin: 20px; }
    nav a { margin-right: 10px; }
    .done { text-decoration: line-through; color: gray; }
</style>
</head>
<body>

<h1>買い物リスト</h1>
<nav>
    <a href="/shoppingitem/top">TOP</a>
    <?php foreach ($categories as $cat): ?>
        <a href="/shoppingitem/category/<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></a>
    <?php endforeach; ?>
</nav>
<button onclick="location.href='/shoppingitem/create'">追加</button>
<hr>

<?php if (\Fuel\Core\Session::get_flash('success')): ?>
    <div style="color: green; border: 1px solid green; padding: 5px; margin-bottom: 10px;">
        <?php echo \Fuel\Core\Session::get_flash('success'); ?>
    </div>
<?php endif; ?>

<?php if (\Fuel\Core\Session::get_flash('error')): ?>
    <div style="color: red; border: 1px solid red; padding: 5px; margin-bottom: 10px;">
        <?php echo \Fuel\Core\Session::get_flash('error'); ?>
    </div>
<?php endif; ?>


<div>
    <?php echo $content; ?>
</div>

</body>
</html>
