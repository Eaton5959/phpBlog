<?php
/*
 * @Author: Eaton5959 eaton5959@163.com
 * @Date: 2024-02-03 21:03:11
 * @LastEditors: Eaton5959 eaton5959@163.com
 * @LastEditTime: 2024-02-03 21:26:57
 * @FilePath: \phpBlog\index.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */
require_once 'application/config/database.php';
require_once 'application/models/TagModel.php';
require_once './application/models/ArticleModel.php';
require_once 'application/models/AdminModel.php';

$db = createDatabaseConnection();
$AdminModel = new AdminModel($db)
?>

<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>个人博客 - 首页</title>
    <link rel="stylesheet" href="public/css/main.css">
</head>

<body>
    <header id="site-header">
        <div class="container header-title-container">
            <h1 class="header-maintitle">我的角落 blog</h1>
            <p class="header-subtitle">神秘的我什么也没留下</p>
        </div>

        <nav id="main-navigation">
            <ul class="nav-links">
                <?php

                if ($AdminModel->isLoggedIn()) { ?>
                    <li><a href="application/views/admin/manage_articles.php" class="nav-link">管理文章</a></li>
                    <li><a href="?logout" class="nav-link">退出登录</a></li>
                    <?php 
                    if (isset($_GET['logout'])) {
                        $AdminModel->logout();
                    }
                    ?>
                <?php } else { ?>
                    <li><a href="application/views/admin/login.php" class="nav-link">作者登录</a></li>
                <?php } ?>

                <!-- 标签列表 -->
                <?php
                $tagModel = new TagModel($db);
                $tags = $tagModel->getAllTags();

                foreach ($tags as $tag) {
                    echo '<li class="nav-item"><a href="tags.php?id=' . htmlspecialchars($tag['id']) . '" class="nav-link">' . htmlspecialchars($tag['id']) . '</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>

    <main id="content-container">
        <section class="articles-list">
            <?php
            $articleModel = new ArticleModel($db);
            $articles = $articleModel->getAllArticles();

            foreach ($articles as $article) {
                echo '<article class="article-preview">';
                echo '<header class="article-header">';
                echo '<h2 class="article-title"><a href="frontend/article.php?id=' . htmlspecialchars($article['id']) . '">' . htmlspecialchars($article['title']) . '</a></h2>';
                echo '</header>';
                echo '<div class="article-excerpt">';
                echo '<p>' . htmlspecialchars(substr($article['content'], 0, 200)) . '...</p>';
                echo '</div>';
                echo '</article>';
            }
            ?>
        </section>
    </main>

    <footer id="site-footer">
        <div class="footer-content">
            <p>&copy; 2023 liyu's blog. All rights reserved.</p>
        </div>
    </footer>

    <script src="./public/js/main.js"></script>
</body>

</html>