<?php
//ini_set('display_errors', 1);

session_start();
if (isset($_SESSION['user']) != "") {
  header("Location: bbs.php");
}

include_once 'db_connect.php';

if (!empty($_POST['username'])) {
  $username2 = $_POST['username'];
  $email = $_POST['email'];
  $password2 = $_POST['password'];
  $password2 = password_hash($password2, PASSWORD_DEFAULT);
}

if (!empty($username2) && !empty($email) && !empty($password2)) {
  $sql = "insert into users (username,email,password) values (:username,:email,:password)";
  $stmt = $db->prepare($sql);
  $stmt->bindParam(':username', $username2, PDO::PARAM_STR);
  $stmt->bindParam(':email', $email, PDO::PARAM_STR);
  $stmt->bindParam(':password', $password2, PDO::PARAM_STR);

  if ($rs = $stmt->execute()) {
    echo "<div class=\"alert alert-success\" role=\"alert\">登録しました</div>";
  } else {
    echo "<div class=\"alert alert-danger\" role=\"alert\">エラーが発生しました。</div>";
  }
}
?>
<!DOCTYPE HTML>
<html lang="ja">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PHPの会員登録機能</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
</head>

<body>
  <div class="col-xs-6 col-xs-offset-3">

    <form method="post">
      <h1>会員登録フォーム</h1>
      <div class="form-group">
        <input type="text" class="form-control" name="username" placeholder="ユーザー名" required />
      </div>
      <div class="form-group">
        <input type="email" class="form-control" name="email" placeholder="メールアドレス" required />
      </div>
      <div class="form-group">
        <input type="password" class="form-control" name="password" placeholder="パスワード" required />
      </div>
      <button type="submit" class="btn btn-default" name="signup">会員登録する</button>
      <a href="index.php">ログインはこちら</a>
    </form>

  </div>
</body>

</html>