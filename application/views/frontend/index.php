<?php
// frontend/index.php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/ArticleModel.php';

$articleModel = new ArticleModel(createDatabaseConnection());
$latestArticles = $articleModel->getLatestArticles(10); // 获取最新发布的10篇文章

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>首页 - Your Blog Name</title>
    <!-- 引入CSS和JavaScript文件 -->
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>

<header>
    <nav>
        <a href="/">首页</a>
        <a href="/tags">标签</a>
        <!-- 添加其他导航链接，如：关于、联系我们等 -->
    </nav>
</header>

<main>
    <h1>最新文章</h1>

    <?php if (!empty($latestArticles)): ?>
        <ul class="articles-list">
            <?php foreach ($latestArticles as $article): ?>
                <li>
                    <a href="?action=view&id=<?php echo $article['id']; ?>">
                        <?php echo htmlspecialchars($article['title']); ?>
                    </a>
                    <p>作者：<?php echo htmlspecialchars($article['author']); ?></p>
                    <p>发布日期：<?php echo date('Y-m-d', strtotime($article['created_at'])); ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>暂无文章。</p>
    <?php endif; ?>

    <!-- 可以添加更多内容，如热门文章、推荐文章等 -->
</main>

<footer>
    <p>&copy; 2023 Your Blog Name</p>
</footer>

</body>
</html>