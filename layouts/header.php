<?php
$get_domain = $_SERVER['SERVER_NAME'];
$get_uri = $_SERVER['REQUEST_URI'];
$url = $get_domain . $get_uri;
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
  <title>シンプル商品管理</title>
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700;900&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <!-- Original CSS -->
  <link rel="stylesheet" href="../assets/css/common.css">
  <link rel="stylesheet" href="../assets/css/layouts.css">
  <link rel="stylesheet" href="../assets/css/components.css">
  <link rel="stylesheet" href="../assets/css/page.css">
  <!-- Font Awesome -->
  <script src="https://kit.fontawesome.com/566b522bd3.js" crossorigin="anonymous"></script>
</head>

<body>
  <header class="l-header">
    <div class="l-header__inner">
      <a href="../" class="l-header__logo">シンプル商品管理アプリ</a>
      <!-- TopページのみNavを表示 -->
      <?php
      if ($url === $get_domain . '/') :
      ?>
        <nav class="l-header__nav">
          <ul class="l-header__nav-lists">
            <li class="l-header__nav-list">
              <a href="../read.php" class="l-header__nav-link">商品一覧へ</a>
            </li>
          </ul>
        </nav>
      <?php endif; ?>

    </div>
  </header>