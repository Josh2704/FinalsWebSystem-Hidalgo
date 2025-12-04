<?php

require_once 'connectdb.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $fullname = trim($_POST['fullname'] ?? '');

    if($username === '' || $password === ''){
        $msg = "Username and password required.";
    } else {
        $conn = Connect();
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password, fullname) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $username, $hash, $fullname);
        $ok = $stmt->execute();
        $stmt->close();
        $conn->close();
        if($ok){
            $msg = "Admin created. Delete or secure setup_admin.php now.";
        } else {
            $msg = "Error: " . htmlspecialchars($conn->error);
        }
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Create Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h3>Create Admin (Run once)</h3>
    <?php if(!empty($msg)): ?>
      <div class="alert alert-info"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>
    <form method="post">
      <div class="mb-3">
        <label>Username</label>
        <input name="username" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Password</label>
        <input name="password" type="password" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Full name</label>
        <input name="fullname" class="form-control">
      </div>
      <button class="btn btn-primary">Create Admin</button>
    </form>
  </div>
</body>
</html>
