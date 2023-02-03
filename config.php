<!-- DB接続テスト -->
<?php
$db_name = getenv('DB_NAME');
$db_host = getenv('DB_HOSTNAME');
$db_user = getenv('DB_USERNAME');
$db_pass = getenv('DB_PASSWORD');

try {
  $dbh = new PDO("mysql:host={$db_host};dbname={$db_name};", $db_user, $db_pass);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  exit('エラーが発生しました。' . $e->getMessage());
}
?>