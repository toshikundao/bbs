<?php

//ini_set('display_errors', 1);
session_start();
if (isset($_SESSION['user']) != "") {
  header("Location: bbs.php");
}
include_once 'db_connect.php';

if (!empty($_POST['email'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];
}

if (!empty($email) && !empty($password)) {
  $sql = "select * from users where email=(:email)";
  $stmt = $db->prepare($sql);
  $stmt->bindParam(':email', $email, PDO::PARAM_STR);
  if (!$rs = $stmt->execute()) {
    die("not query:" . $rs->errorInfo());
  }
  while ($row = $stmt->fetch()) {
    $db_hashed_pwd = $row['password'];
    $user_id = $row['user_id'];
  }

  if (password_verify($password, $db_hashed_pwd)) {
    $_SESSION['user'] = $user_id;
    header("Location: bbs.php");
    exit;
  } else {
    echo "<div class=\"alert alert-danger\" role=\"alert\">メールアドレスとパスワードが一致しません。</div>";
  }
}


?>

<!DOCTYPE HTML>
<html lang="ja">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PHPのログイン機能</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
</head>
</head>

<body>
  <div class="col-xs-6 col-xs-offset-3">

    <form method="post">
      <h1>ログインフォーム</h1>
      <div class="form-group">
        <input type="email" class="form-control" name="email" placeholder="メールアドレス" required />
      </div>
      <div class="form-group">
        <input type="password" class="form-control" name="password" placeholder="パスワード" required />
      </div>
      <button type="submit" class="btn btn-default" name="login">ログインする</button>
      <a href="register.php">会員登録はこちら</a>
    </form>

  </div>
</body>

</html>