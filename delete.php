<?php
require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/libs/FormSanitize.php');

// idパラメータがあった場合
if (!empty($_GET['id'])) {
  $id = new FormSanitize($_GET['id'], ENT_QUOTES, 'UTF-8');
  $id = $id->sanitize();

  try {
    $sql = 'DELETE FROM products WHERE id = :id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $delete_count = $stmt->rowCount();

    $dbh = null;
    header("Location: ./read.php?delete_count={$delete_count}");
  } catch (PDOException $e) {
    exit('エラーが発生しました。' . $e->getMessage());
  }
  // idパラメータがなかった場合
} else {
  header('refresh:3;url=./read.php');

  echo '<p>';
  exit('ID情報が見つかりませんでした。3秒後の商品一覧ページへ。');
  echo '</p>';
}
