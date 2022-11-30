<?php
$dsn      = 'mysql:dbname=eVocaburary;host=localhost;charset=utf8mb4';
$user     = 'root';
$password = 'root';

// submitパラメータの値が存在するとき(「登録」ボタンを押したとき)の処理
if(isset($_POST['submit'])) {
  try {
    $pdo = new PDO($dsn, $user, $password);

    // 動的に変わる値をプレースホルダに置き換えたINSERT文をあらかじめ用意する
    $sql_insert = '
      INSERT INTO vocaburaries (add_date, vocaburary, PoS, meaning)
      VALUES (:add_date, :vocaburary, :PoS, :meaning)
    ';
    $stmt_insert = $pdo->prepare($sql_insert);

    // bindValue()メソッドを使って実際の値をプレースホルダにバインドする(割り当てる)
    $stmt_insert->bindValue(':add_date', $_POST['add_date'], PDO::PARAM_STR);
    $stmt_insert->bindValue(':vocaburary', $_POST['vocaburary'], PDO::PARAM_STR);
    $stmt_insert->bindValue(':PoS', $_POST['PoS'], PDO::PARAM_STR);
    $stmt_insert->bindValue(':meaning', $_POST['meaning'], PDO::PARAM_STR);

    // SQL文を実行する
    $stmt_insert->execute();

    // 追加した件数を取得する
    $count = $stmt_insert->rowCount();

    $message = "商品を{$count}件登録しました。";

    // 商品一覧ページにリダイレクトさせる(同時にmessageパラメータも渡す)
    header("Location: read.php?message={$message}");
  } catch (PDOException $e) {
    exit($e->getMessage());
  }
}

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
          <input type="text" name="PoS" maxlength="50" required>
          <!-- <select name="PoS" required> -->

            <!-- <option disabled selected value>選択してください</option> -->
            
            
            <?php
            // 配列の中身を順番に取り出し、セレクトボックスの選択肢として出力する
            // foreach($PoSs as $PoS) {
              // echo "<option value='{$PoS}'>{$PoS}</option>";
            // }
            // ?>
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