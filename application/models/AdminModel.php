<?php
/*
 * @Author: Eaton5959 eaton5959@163.com
 * @Date: 2024-02-03 01:49:17
 * @LastEditors: Eaton5959 eaton5959@163.com
 * @LastEditTime: 2024-02-03 02:04:54
 * @FilePath: \blog_app\application\models\AdminModel.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */

// application/models/AdminModel.php

class AdminModel {
    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    // 哈希密码并存储
    public function hashAndSavePassword($username, $password)
    {
        // 请确保在实际应用中使用安全的密码哈希函数，如 password_hash()
        // 这里仅作简单演示，不建议直接用于生产环境
        $hashed_password = md5($password); // 实际应用中应使用 password_hash()

        // 插入或更新管理员用户的密码
        $sql = "UPDATE admin_users SET password_hash = :hashed_password WHERE username = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':hashed_password', $hashed_password);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
    }

    // 验证用户名和密码
    public function authenticate($username, $password)
    {
        // 获取数据库中的用户信息
        $sql = "SELECT * FROM admin_users WHERE username = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        // 如果用户存在且密码正确（使用相同的哈希方法比较）
        if ($admin && $admin['password_hash'] === md5($password)) { // 实际应用中应使用 password_verify()
            // 登录成功，可以创建session或token表示登录状态
            session_start();
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            return true;
        }

        return false;
    }

    // 检查是否已登录
    public function isLoggedIn()
    {
        session_start();
        return isset($_SESSION['admin_id']) && isset($_SESSION['admin_username']);
    }

    // 注销登录
    public function logout()
    {
        session_start();
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_username']);
        session_destroy();
    }
}

?>