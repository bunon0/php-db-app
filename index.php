<!-- DB接続テスト -->
<?php
$db_name = getenv('DB_NAME');
$db_host = getenv('DB_HOST');
$db_user = getenv('DB_USER');
$db_pass = getenv('DB_PASS');


try {
  $dbh = new PDO("mysql:host={$db_host};dbname={$db_name};", $db_user, $db_pass);
  $sql = 'SELECT * FROM products';
  $stmt = $dbh->query($sql);
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  var_dump($results[0]);

  $dbh = null;
} catch (PDOException $e) {
  exit('エラーが発生しました。' . $e->getMessage());
}
?>


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