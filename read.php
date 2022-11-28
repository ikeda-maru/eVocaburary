<?php
$dsn      = 'mysql:dbname=eVocaburary;host=localhost;charset=utf8mb4';
$user     = 'root';
$password = 'root';

try {
  $pdo = new PDO($dsn, $user, $password);

  $sql_select = 'SELECT * FROM vocaburaries';

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
          <!-- 並び替えボタンと検索ボタンを作成する -->
        </div>
        <a href="#" class="btn">単語登録</a>
      </div>
      <table class="vocaburaries-table">
        <tr>
          <th>語彙</th>
          <th>品詞</th>
          <th>意味</th>
        </tr>
        <?php
        foreach ($vocaburaries as $vocaburary) {
          $table_row = "
            <tr>
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