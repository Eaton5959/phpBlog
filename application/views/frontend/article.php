<?php
/*
 * @Author: Eaton5959 eaton5959@163.com
 * @Date: 2024-02-03 01:50:10
 * @LastEditors: Eaton5959 eaton5959@163.com
 * @LastEditTime: 2024-02-03 15:27:41
 * @FilePath: \blog_app\application\views\frontend\article.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */
// frontend/article.php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/ArticleModel.php';

$article_id = $_GET['id'] ?? 0;

if ($article_id <= 0) {
    header("Location: ../index.php"); // 如果没有文章ID，则重定向到首页
    exit;
}

$articleModel = new ArticleModel(createDatabaseConnection());
$article = $articleModel->getArticleById($article_id);

if (empty($article)) {
    header("Location: ../404.php"); // 如果获取的文章为空，则重定向到404页面
    exit;
}

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($article['title']); ?></title>
    <!-- 引入CSS和JavaScript文件 -->
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>

<header>
    <nav>
        <a href="/">返回首页</a>
    </nav>
</header>

<main>
    <article>
        <h1><?php echo htmlspecialchars($article['title']); ?></h1>
        <!-- <p>作者：<?php echo htmlspecialchars($article['author']); ?></p> -->
        <p>发布日期：<?php echo date('Y-m-d', strtotime($article['created_at'])); ?></p>
        <div class="content"><?php echo htmlspecialchars($article['content']); ?></div>
        
        <?php if (!empty($article['tags'])): ?>
            <div class="tags">
                标签：
                <?php foreach ($article['tags'] as $tag): ?>
                    <span><?php echo htmlspecialchars($tag['tag_name']); ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </article>
</main>

<footer>
    <p>&copy; 2023 Your Blog Name</p>
</footer>

</body>
</html>