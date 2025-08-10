<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title><?php echo $title; ?></title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.1/knockout-min.js"></script>
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
<hr>

<div>
    <?php echo $content; ?>
</div>

</body>
</html>
