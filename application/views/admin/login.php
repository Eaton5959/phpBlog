<!-- views/admin/login.php -->
<?php

?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <title>管理员登录</title>
</head>

<body>
    <?php if (isset($errorMessage)) : ?>
        <p style="color: red;"><?php echo htmlspecialchars($errorMessage); ?></p>
    <?php endif; ?>

    <form action="?action=login" method="post">
        <label for="username">用户名：</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">密码：</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">登录</button>
    </form>

    <?php
    require_once '../../models/AdminModel.php';
    require_once '../../config/database.php';

    session_start();
    $db = createDatabaseConnection();
    $AdminModel = new AdminModel($db);

    // 检查是否已提交表单
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['username'];
        $pw =  $_POST['password'];

        $status = $AdminModel->authenticate($name, $pw);

        if ($status) {
            $_SESSION['admin_logged_in'] = true;
            header('Location: /');
        } else {
            $error = "无效的用户名或密码";
        }
    }
    ?>
</body>

</html>