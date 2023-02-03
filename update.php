<?php
require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/libs/FormSanitize.php');

if (!empty($_POST['submit'])) {
  $post = new FormSanitize($_POST, ENT_QUOTES, 'UTF-8');
  $post = $post->sanitize_array();
  $id = new FormSanitize($_GET['id'], ENT_QUOTES, 'UTF-8');
  $id = $id->sanitize();

  try {
    $sql = '
      UPDATE products
      SET product_code = :product_code, product_name = :product_name,
          price = :price, stock_quantity = :stock_quantity, vendor_code = :vendor_code
      WHERE id = :id
      ';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':product_code', $post['product_code'], PDO::PARAM_INT);
    $stmt->bindValue(':product_name', $post['product_name'], PDO::PARAM_STR);
    $stmt->bindValue(':price', $post['price'], PDO::PARAM_INT);
    $stmt->bindValue(':stock_quantity', $post['stock_quantity'], PDO::PARAM_INT);
    $stmt->bindValue(':vendor_code', $post['vendor_code'], PDO::PARAM_INT);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $update_count = $stmt->rowCount();

    $dbh = null;
    header("Location: ./read.php?create_count={$update_count}");
  } catch (PDOException $e) {
    exit('エラーが発生しました。' . $e->getMessage());
  }
}

try {
  // 仕入先コードをDBから取得する
  $sql = 'SELECT vendor_code FROM vendors';
  $stmt = $dbh->query($sql);
  $vendors = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
  exit('エラーが発生しました。' . $e->getMessage());
}

// idパラメータが渡って来た場合
if (!empty($_GET['id'])) {
  try {
    $id = new FormSanitize($_GET['id'], ENT_QUOTES, 'UTF-8');
    $id = $id->sanitize();
    $id = intval($id);

    // 仕入先コードをDBから取得する
    $sql = 'SELECT * FROM products WHERE id = :id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    $dbh = null;
  } catch (PDOException $e) {
    exit('エラーが発生しました。' . $e->getMessage());
  }
} else {
  header('refresh:3;url=./read.php');

  echo '<p>';
  exit('ID情報が見つかりませんでした。3秒後の商品一覧ページへ。');
  echo '</p>';
}
?>

<?php
require_once(__DIR__ . '/layouts/header.php')
?>

<main class="l-main">
  <div class="l-main__inner">
    <div class="p-create">
      <div class="p-create__contents">
        <h1 class="p-create__title">商品編集</h1>
        <div class="p-create__btn-wrapper">
          <button class="p-create__btn-back" onclick="history.back();">
            <i class="fa-solid fa-angle-left"></i>
            戻る
          </button>
        </div>
        <?php if ($product) : ?>
          <form action="./update.php?id=<?= $id; ?>" class="c-form" method="post">
            <div class="c-form__part">
              <label for="product_code" class="c-form__label">商品コード</label>
              <input type="number" class="c-form__input" id="product_code" name="product_code" value="<?= $product['product_code']; ?>" min=0 max=10000000000 required>
            </div>
            <div class="c-form__part">
              <label for="product_name" class="c-form__label">商品名</label>
              <input type="text" class="c-form__input" id="product_name" name="product_name" value="<?= $product['product_name']; ?>" maxlength="50" required>
            </div>
            <div class="c-form__part">
              <label for="price" class="c-form__label">単価</label>
              <input type="text" class="c-form__input" id="price" name="price" value="<?= $product['price']; ?>" min=0 max=10000000000 required>
            </div>
            <div class="c-form__part">
              <label for="stock_quantity" class="c-form__label">在庫数</label>
              <input type="text" class="c-form__input" id="stock_quantity" name="stock_quantity" value="<?= $product['stock_quantity']; ?>" min=0 max=10000000000 required>
            </div>
            <div class=" c-form__part">
              <label for="vendor_code" class="c-form__label">仕入先コード</label>
              <select class="c-form__select" name="vendor_code" id="vendor_code" min=0 max=10000000000 required>
                <option value="" disabled selected>選択してください</option>
                <?php foreach ($vendors as $vendor) {
                  if ($product['vendor_code'] === $vendor) {
                    echo "
                    <option value='{$vendor}' selected>{$vendor}</option>
                    ";
                  } else {
                    echo "
                    <option value='{$vendor}'>{$vendor}</option>
                    ";
                  }
                }
                ?>
              </select>
            </div>
            <div class="c-form__btn-wrapper">
              <button type="submit" class="c-form__submit" name="submit" value="update">登録</button>
            </div>
          </form>
        <?php else : ?>
          <p class="p-update__message">商品情報が見つかりませんでした。</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</main>

<?php
require_once(__DIR__ . '/layouts/footer.php')
?>