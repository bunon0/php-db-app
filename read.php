<?php
require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/libs/FormSanitize.php');

try {
  // sortパラメータが渡された時の処理
  if (!empty($_GET['sort'])) {
    $sort = new FormSanitize($_GET['sort'], ENT_QUOTES, 'UTF-8');
    $sort = $sort->sanitize();
  } else {
    $sort = null;
  }

  // keywordパラメータが渡された時の処理
  if (!empty($_GET['keyword'])) {
    $get_keyword = new FormSanitize($_GET['keyword'], ENT_QUOTES, 'UTF-8');
    $get_keyword = $get_keyword->sanitize();
  } else {
    $get_keyword = null;
  }
  $keyword = "%{$get_keyword}%";

  // sortパラメータの値でsqlを変更する
  if ($sort === 'desc') {
    $sql = 'SELECT * FROM products WHERE product_name LIKE :keyword ORDER BY updated_at DESC';
  } else if ($sort === 'asc') {
    $sql = 'SELECT * FROM products WHERE product_name LIKE :keyword ORDER BY updated_at ASC';
  } else {
    $sql = 'SELECT * FROM products WHERE product_name LIKE :keyword ORDER BY product_code ASC';
  }

  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':keyword', $keyword, PDO::PARAM_STR);
  $stmt->execute();
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
          <div class="p-read__widget-filter">
            <div class="p-read__widget-sort">
              <a href="./read.php?sort=asc&keyword=<?= $get_keyword; ?>" class="p-read__widget-asc">
                <i class="fa-solid fa-arrow-down-1-9"></i>
              </a>
              <a href="./read.php?sort=desc&keyword=<?= $get_keyword; ?>" class="p-read__widget-desc">
                <i class="fa-solid fa-arrow-down-9-1"></i>
              </a>
            </div>
            <form class="p-read__widget-search" action="./read.php" method="get">
              <input type="hidden" name="sort" value="<?= $sort; ?>">
              <input class="p-read__widget-input" type="text" name="keyword" value="<?= $get_keyword; ?>" placeholder="商品名で検索">
            </form>
          </div>
        </div>

        <div class="p-read__table-wrapper">
          <table class="p-read__table">
            <tr class="p-read__table-row p-read__table-row--head">
              <th class=" p-read__table-th">
                商品コード
              </th>
              <th class="p-read__table-th" colspan="2">
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
                <td class='p-read__table-td' data-label="商品名" colspan="2">
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