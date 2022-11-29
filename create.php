<?php
$dsn      = 'mysql:dbname=eVocaburary;host=localhost;charset=utf8mb4';
$user     = 'root';
$password = 'root';

// セレクトボックスの選択肢として設定するため、品詞コードの配列を取得する
try {
  $pdo = new PDO($dsn, $user, $password);

  // vocaburariesテーブルからPoSカラムのデータを取得するためのSQL文を変数$sql_selectに代入する
  $sql_select = 'SELECT PoS FROM vocaburaries';

  // SQL文を実行する
  $stmt_select = $pdo->query($sql_select);

  // SQL文の実行結果を配列で取得する
  $PoS = $stmt_select->fetchAll(PDO::FETCH_COLUMN);
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
    <article class="registration">
      <h1>単語登録</h1>
      <div class="back">
        <a href="read.php" class="btn">&lt; 戻る</a>
      </div>
      <form action="create.php" method="post" class="registration-form">
        <div>
          <label for="add_date">追加日付</label>
          <input type="date" name="add_date" value="<?php echo date('Y-m-d'); ?>" required>
          
          <label for="vocaburary">語彙</label>
          <input type="text" name="vocaburary" maxlength="50" required>

          <label for="PoS">品詞</label>
          <select name="PoS" required>
            <option disabled selected value>選択してください</option>
            <?php
            // 配列の中身を順番に取り出し、セレクトボックスの選択肢として出力する
            foreach($PoSs as $PoS) {
              echo "<option value='{$PoS}'>{$PoS}</option>";
            }
            ?>
          </select>

          <label for="meaning">意味</label>
          <input type="text" name="meaning" maxlength="50" required>
        </div>
        <button type="submit" class="submit-btn" name="submit" value="create">登録</button>
      </form>
    </article>
  </main>
  <footer>
    <p class="copyright">&copy; eVocaburary All rights reserved.</p>
  </footer>
</body>
</html>