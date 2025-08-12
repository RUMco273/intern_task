<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<!-- トークン生成 -->
<meta name="csrf-token" content="<?php echo \Security::fetch_token(); ?>">

<!-- css読み込み -->
<link href="https://unpkg.com/sanitize.css" rel="stylesheet"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<?php echo Asset::css('style.css'); ?>

<title><?php echo $title; ?></title>

<!-- JS読み込み -->
<script src="https://cdn.jsdelivr.net/npm/knockout@3.5.1/build/output/knockout-latest.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>

<h1 class="header-container">買い物リスト</h1>
<nav>
    <a class= "btn btn-outline-primary btn-lg" href="/shoppingitem/top">TOP</a>
    <?php foreach ($categories as $cat): ?>
        <a class= "btn btn-outline-primary btn-lg" href="/shoppingitem/category/<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></a>
    <?php endforeach; ?>
</nav>


<hr>

<!-- セッションを用いたアラート -->
<?php if (\Fuel\Core\Session::get_flash('success')): ?>
    <div class="alert alert-success">
        <?php echo \Fuel\Core\Session::get_flash('success'); ?>
    </div>
<?php endif; ?>

<?php if (\Fuel\Core\Session::get_flash('error')): ?>
    <div class="alert alert-danger">
        <?php echo \Fuel\Core\Session::get_flash('error'); ?>
    </div>
<?php endif; ?>


<div>
    <?php echo $content; ?>
</div>
</body>
</html>
