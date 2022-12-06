<?php
$dsn      = 'mysql:dbname=eVocaburary;host=localhost;charset=utf8mb4';
$user     = 'root';
$password = 'root';

try {
  $pdo = new PDO ($dsn, $user, $password);

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
    <article class="questioning">
      <h1>問題</h1>
        <?php
          foreach ($vocaburaries as $vocaburary) {
            $meaning = "
            <p>{$vocaburary['meaning']}</p>
            ";
          }
          echo $meaning[0];
        ?>
      <input type="text" name="answer">
      <a href="" class="btn">答え</a>
    </article>
  </main>
</body>
</html>