<?php
require_once(__DIR__ . '/layouts/header.php')
?>

<main class="l-main">
  <div class="l-main__inner">
    <div class="p-top">
      <div class="p-top__contents">
        <h1 class="p-top__title">商品管理アプリ</h1>
        <p class="p-top__title-read">PHPとデータベースでシンプルな商品管理アプリ</p>
        <div class="p-top__btn-wrapper">
          <a href="./read.php" class="p-top__btn">商品一覧へ</a>
        </div>
      </div>
    </div>
  </div>
</main>

<?php
require_once(__DIR__ . '/layouts/footer.php')
?>