<?php
require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/libs/FormSanitize.php');


$test = new FormSanitize('<p>hello</p>', ENT_QUOTES, 'UTF-8');
$test = $test->sanitize();
var_dump($test);

try {
  if (isset($_GET)) {
  }

  $sql = 'SELECT * FROM products';
  $stmt = $dbh->query($sql);
  $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <div class="p-read">
      <div class="p-read__contents">
        <h1 class="p-read__title">商品一覧</h1>
        <div class="p-read__widget">
          <div class="p-read__widget-sort">
            <a href="./read.php?sort=desc" class="p-read__widget-desc">
              <i class="fa-solid fa-arrow-down-z-a"></i>
            </a>
            <a href="./read.php?sort=asc" class="p-read__widget-asc">
              <i class="fa-solid fa-arrow-up-a-z"></i>
            </a>
          </div>
        </div>

        <div class="p-read__table-wrapper">
          <table class="p-read__table">
            <tr class="p-read__table-row p-read__table-row--head">
              <th class=" p-read__table-th">
                商品コード
              </th>
              <th class="p-read__table-th">
                商品名
              </th>
              <th class="p-read__table-th">
                単価
              </th>
              <th class="p-read__table-th">
                在庫数
              </th>
              <th class="p-read__table-th">
                仕入先コード
              </th>
              <th class="p-read__table-th">
                編集
              </th>
              <th class="p-read__table-th">
                削除
              </th>
            </tr>
            <!-- DBの商品リストの表示 -->
            <?php foreach ($products as $product) : ?>
              <tr class="p-read__table-row">
                <td class='p-read__table-td' data-label="商品コード">
                  <?= $product['product_code']; ?>
                </td>
                <td class='p-read__table-td' data-label="商品名">
                  <?= $product['product_name'] ?>
                </td>
                <td class='p-read__table-td' data-label="価格">
                  <?= $product['price']; ?>
                </td>
                <td class='p-read__table-td' data-label="在庫数">
                  <?= $product['stock_quantity'] ?>
                </td>
                <td class='p-read__table-td' data-label="仕入先コード">
                  <?= $product['vendor_code'] ?>
                </td>
                <td class='p-read__table-td'>
                  編集
                </td>
                <td class='p-read__table-td'>
                  削除
                </td>
              </tr>
            <?php endforeach; ?>
          </table>
        </div>
      </div>
    </div>
  </div>
</main>

<?php
require_once(__DIR__ . '/layouts/footer.php')
?>