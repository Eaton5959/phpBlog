<?php
/*
 * @Author: Eaton5959 eaton5959@163.com
 * @Date: 2024-02-03 01:50:15
 * @LastEditors: Eaton5959 eaton5959@163.com
 * @LastEditTime: 2024-02-03 15:58:47
 * @FilePath: \blog_app\application\views\frontend\tags.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */
// frontend/tags.php

require_once  '../../config/database.php';
require_once  '../../models/ArticleModel.php';

$tag_id = $_GET['id'] ?? 0;

if ($tag_id <= 0) {
    header("Location: ../index.php"); // 如果没有标签ID，则重定向到首页
    exit;
}

$articleModel = new ArticleModel(createDatabaseConnection());

// 根据选定的标签查询相关文章
$articlesWithTag = $articleModel->getArticlesByTagId($tag_id);

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>标签：<?php echo htmlspecialchars(getTagNameById($tag_id)); ?></title>
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
    <h1>标签：<?php echo htmlspecialchars(getTagNameById($tag_id)); ?> 的相关文章</h1>

    <?php if (!empty($articlesWithTag)): ?>
        <ul class="articles-list">
            <?php foreach ($articlesWithTag as $article): ?>
                <li>
                    <a href="?action=view&id=<?php echo $article['id']; ?>">
                        <?php echo htmlspecialchars($article['title']); ?>
                    </a>
                    <!-- <p>作者：<?php echo htmlspecialchars($article['author']); ?></p> -->
                    <p>发布日期：<?php echo date('Y-m-d', strtotime($article['created_at'])); ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>暂无与此标签相关的文章。</p>
    <?php endif; ?>
</main>

<footer>
    <p>&copy; 2023 Your Blog Name</p>
</footer>

</body>
</html>

<?php
// 假设这是一个辅助函数，用于通过标签ID获取标签名称
function getTagNameById($tag_id)
{
    // 在实际项目中，您需要从数据库或缓存中获取标签名称
    // 这里仅为示例，假设我们有一个全局函数可以获取标签名
    // 实际场景下，您可能需要在ArticleModel或其他模型类中实现这个功能
    return '示例标签名称'; 
}
?>