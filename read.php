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

  // パラメータの値によってSQL文を変更する
  if ($order === 'desc') {
    $sql_select = 'SELECT * FROM vocaburaries ORDER BY add_date DESC';
  } else {
    $sql_select = 'SELECT * FROM vocaburaries ORDER BY add_date ASC';
  }

  $stmt_select = $pdo->query($sql_select);

  $vocaburaries = $stmt_select->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  exit($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>単語一覧</title>
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
          <a href="read.php?order=desc">
            <img src="images/desc.png" alt="降順に並び替え" class="sort-img">
          </a>
          <a href="read.php?order=asc">
            <img src="images/asc.png" alt="昇順に並び替え" class="sort-img">
          </a>
        </div>
        <a href="#" class="btn">単語登録</a>
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
              <td>{$vocaburary['type']}</td>
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