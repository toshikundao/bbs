<?php
//ini_set('display_errors', 1);
session_start();
include_once 'db_connect.php';
if (!isset($_SESSION['user'])) {
  header("Location: index.php");
}

$user_id = $_SESSION['user'];
$sql="select * from users where user_id=(:user_id)";
$stmt = $db->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
if (!$rs = $stmt->execute()) {
  die("not query:" . $rs->errorInfo());
}
$row = $stmt->fetch();
$out=sprintf("<h4>名前：%s<br><br>email：%s</h4>",$row['username'],$row['email']);
$db = null;

?>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <title>掲示板</title>
</head>

<body>
  <nav class="navbar fixed-top navbar-expand-sm navbar-dark bg-dark">
    <a href="index.php" class="navbar-brand">KEIJIBAN</a>
    <div class="navbar-nav">
      <a class="nav-item nav-link" href="logout.php?logout">ログアウト</a>
      <a class="nav-item nav-link" href="index.php">ホーム</a>
    </div>
  </nav>

  <div class="w-75 m-auto pt-5">
    <h1 class="text-center pt-2">MYアカウント</h1>
    <?= $out ?>
  </div>
</body>

</html>