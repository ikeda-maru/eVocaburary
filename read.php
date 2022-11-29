<?php
$dsn      = 'mysql:dbname=eVocaburary;host=localhost;charset=utf8mb4';
$user     = 'root';
$password = 'root';

try {
  $pdo = new PDO($dsn, $user, $password);

  // orderパラメータの値が存在すれば(並び替えボタンを押したとき)、その値を変数$orderに代入する
  if (isset($_GET['order'])) {
    $order = $_GET['order'];
  } else {
    $order = NULL;
  }

  // keywordパラメータの値が存在すれば(単語を検索したとき)、その値を変数$keywordに代入する
  if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
  } else {
    $keyword = NULL;
  }

  // パラメータの値によってSQL文を変更する
  if ($order === 'desc') {
    $sql_select = 'SELECT * FROM vocaburaries WHERE vocaburary LIKE :keyword ORDER BY add_date DESC';
  } else {
    $sql_select = 'SELECT * FROM vocaburaries WHERE vocaburary LIKE :keyword ORDER BY add_date ASC';
  }

  // SQL文を用意する
  $stmt_select = $pdo->prepare($sql_select);

  // SQLのLIKE句で使うため、変数$keyword(検索ワード)の前後を%で囲む(部分一致)
  $partial_match = "%{$keyword}%";

  // bindValue()メソッドを使って実際の値をプレースホルダにバインドする(割り当てる)
  $stmt_select->bindValue(':keyword', $partial_match, PDO::PARAM_STR);

  // SQL文を実行する
  $stmt_select->execute();

  $vocaburaries = $stmt_select->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  exit($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>eVocaburary</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <header>
    <nav>
      <a href="index.php">eVocaburary</a>
    </nav>
  </header>
  <main>
    <article class="vocaburaries">
      <h1>単語一覧</h1>
      <div class="vocaburaries-ui">
        <div>
          <a href="read.php?order=desc&keyword=<?= $keyword ?>">
            <img src="images/desc.png" alt="降順に並び替え" class="sort-img">
          </a>
          <a href="read.php?order=asc&keyword=<?= $keyword ?>">
            <img src="images/asc.png" alt="昇順に並び替え" class="sort-img">
          </a>
          <form action="read.php" method="get" class="search-form">
            <input type="hidden" name="order" value="<?= $order ?>">
            <input type="text" class="search-box" placeholder="商品名で検索" name="keyword" value="<?= $keyword ?>">
          </form>
        </div>
        <a href="create.php" class="btn">単語登録</a>
      </div>
      <table class="vocaburaries-table">
        <tr>
          <th>追加日付</th>
          <th>語彙</th>
          <th>品詞</th>
          <th>意味</th>
        </tr>
        <?php
        foreach ($vocaburaries as $vocaburary) {
          $table_row = "
            <tr>
              <td>{$vocaburary['add_date']}</td>
              <td>{$vocaburary['vocaburary']}</td>
              <td>{$vocaburary['PoS']}</td>
              <td>{$vocaburary['meaning']}</td>
            </tr>
          ";
          echo $table_row;
        }
        ?>
      </table>
    </article>
  </main>
  <footer>
    <p class="copyright">&copy; eVocaburary All rights reserved.</p>
  </footer>
</body>
</html>