<?php
$dsn      = 'mysql:dbname=eVocaburary;host=localhost;charset=utf8mb4';
$user     = 'root';
$password = 'root';

// idパラメータの値が存在すれば処理を行う
if(isset($_GET['id'])) {
  try {
    $pdo = new PDO($dsn, $user, $password);

    // idカラムの値をプレースホルダ(:id)に置き換えたSQL文をあらかじめ用意する
    $sql_select_vocaburary   = 'SELECT * FROM vocaburaries WHERE id = :id';
    $stmt_select_vocaburary  = $pdo->prepare($sql_select_vocaburary);

    // bindValue()メソッドを使って実際の値をプレースホルダにバインドする(割り当てる)
    $stmt_select_vocaburary->bindValue(':id', $_GET['id'], PDO::PARAM_INT);

    // SQL文を実行する
    $stmt_select_vocaburary->execute();

    // SQL文の実行結果を配列で取得する
    $vocaburary = $stmt_select_vocaburary->fetch(PDO::FETCH_ASSOC);

    // idパラメータの値と同じidのデータが存在しない場合はエラーメッセージを表示して処理を終了する
    if ($vocaburary === FALSE) {
      exit('idパラメータの値が不正です。');
    }

  } catch (PDOException $e) {
    exit($e->getMessage());
  }
} else {
  // idパラメータの値が存在しない場合はエラーメッセージを表示して処理を停止する
  exit('idパラメータの値が存在しません。');
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
      <h1>単語編集</h1>
      <div class="back">
        <a href="read.php" class="btn">&lt; 戻る</a>
      </div>
      <form action="update.php?id=<?= $_GET['id'] ?>" method="post" class="registration-form">
        <div>
          <label for="add_date">追加日付</label>
          <input type="date" name="add_date" value="<?= $vocaburary['add_date'] ?>" required>
          
          <label for="vocaburary">語彙</label>
          <input type="text" name="vocaburary" value="<?= $vocaburary['vocaburary'] ?>" maxlength="50" required>

          <label for="PoS">品詞</label>
          <select name="PoS" value="<?= $vocaburary['PoS'] ?>" required>
            <option value="名詞">名詞</option>
            <option value="形容詞">形容詞</option>
            <option value="助動詞">助動詞</option>
            <option value="動詞">動詞</option>
            <option value="副詞">副詞</option>
          </select>

          <label for="meaning">意味</label>
          <input type="text" value="<?= $vocaburary['meaning'] ?>" name="meaning" maxlength="50" required>
        </div>
        <button type="submit" class="submit-btn" name="submit" value="update">更新</button>
      </form>
    </article>
  </main>
  <footer>
    <p class="copyright">&copy; eVocaburary All rights reserved.</p>
  </footer>
</body>
</html>