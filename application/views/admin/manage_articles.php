<!DOCTYPE html>
/*
 * @Author: Eaton5959 eaton5959@163.com
 * @Date: 2024-02-03 01:49:56
 * @LastEditors: Eaton5959 eaton5959@163.com
 * @LastEditTime: 2024-02-03 02:22:51
 * @FilePath: \blog_app\application\views\admin\manage_articles.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>文章管理</title>
    <!-- 引入CSS和JavaScript文件 -->
    <link rel="stylesheet" href="/css/admin_styles.css">
    <script src="/js/admin_scripts.js"></script>
</head>
<body>
    <header>
        <nav>
            <a href="/">返回首页</a>
            <a href="?action=add">添加新文章</a>
        </nav>
    </header>

    <main>
        <?php 
        // 需要从AdminController中获取并传递文章列表到此视图
        $articles = isset($articles) ? $articles : []; // 假设控制器已传递文章数据

        if (empty($articles)) {
            echo '<p>暂无文章记录。</p>';
        } else { ?>
            <table>
                <thead>
                    <tr>
                        <th>标题</th>
                        <th>作者</th>
                        <th>创建时间</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($articles as $article): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($article['title']); ?></td>
                            <td><?php echo htmlspecialchars($article['author']); ?></td>
                            <td><?php echo date('Y-m-d H:i:s', strtotime($article['created_at'])); ?></td>
                            <td>
                                <a href="?action=edit&id=<?php echo $article['id']; ?>">编辑</a>
                                <a href="?action=delete&id=<?php echo $article['id']; ?>" onclick="return confirm('确定要删除这篇博文吗？');">删除</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php } ?>
    </main>

    <footer>
        <p>&copy; 2023 Your Blog Name</p>
    </footer>
</body>
</html>