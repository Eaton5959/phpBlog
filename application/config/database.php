<?php
/*
 * @Author: Eaton5959 eaton5959@163.com
 * @Date: 2024-02-03 01:47:38
 * @LastEditors: Eaton5959 eaton5959@163.com
 * @LastEditTime: 2024-02-03 02:01:06
 * @FilePath: \blog_app\application\config\database.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */

// application/config/database.php

class DatabaseConfig {
    private static $config = [
        'host' => '8.137.122.220:3306', // 替换为你的数据库服务器地址
        'dbname' => 'phpblog', // 替换为你的数据库名称
        'username' => 'root', // 替换为你的数据库用户名
        'password' => 'mysql_windjiushini', // 替换为你的数据库密码
        'charset' => 'utf8mb4',
    ];

    public static function getDbConfig() {
        return self::$config;
    }
}

// 示例：创建数据库连接
function createDatabaseConnection() {
    $config = DatabaseConfig::getDbConfig();
    
    $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    
    try {
        $pdo = new PDO($dsn, $config['username'], $config['password'], $options);
        return $pdo;
    } catch (PDOException $e) {
        throw new Exception("Could not connect to the database: {$e->getMessage()}");
    }
}

// 在需要的地方调用createDatabaseConnection函数获取数据库连接实例
$db = createDatabaseConnection();

?>