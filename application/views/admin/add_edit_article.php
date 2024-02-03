<?php
/*
 * @Author: Eaton5959 eaton5959@163.com
 * @Date: 2024-02-03 02:36:20
 * @LastEditors: Eaton5959 eaton5959@163.com
 * @LastEditTime: 2024-02-03 02:36:25
 * @FilePath: \blog_app\application\views\admin\add_edit_article.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */
// admin/add_edit_article.php

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $article_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    
    // 加载文章数据（仅在编辑时需要）
    if ($action === 'edit' && $article_id > 0) {
        $articleModel = new ArticleModel($db);
        $article = $articleModel->getArticleById($article_id);
        $tag_ids = array_column($article['tags'], 'id'); // 假设获取到的文章标签信息是一个关联数组，包含id字段
    } else {
        $article = [
            'title' => '',
            'content' => '',
            'tag_ids' => [],
        ];
    }
} else {
    header('Location: ../manage_articles.php');
    exit();
}

$tags = $tagModel->getAllTags(); // 获取所有标签列表

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title><?php echo $action === 'add' ? '添加新文章' : '编辑文章'; ?></title>
    <!-- 引入CSS和JavaScript文件 -->
    <link rel="stylesheet" href="/css/admin_styles.css">
    <script src="/js/admin_scripts.js"></script>
</head>
<body>
    <form action="?action=<?php echo $action; ?>" method="post">
        <?php if ($action === 'edit'): ?>
            <input type="hidden" name="article_id" value="<?php echo $article_id; ?>">
        <?php endif; ?>

        <label for="title">标题：</label>
        <input type="text" id="title" name="title" required value="<?php echo htmlspecialchars($article['title']); ?>">

        <label for="content">内容：</label>
        <textarea id="content" name="content" rows="10" cols="50" required><?php echo htmlspecialchars($article['content']); ?></textarea>

        <label>选择标签：</label>
        <?php foreach ($tags as $tag): ?>
            <div>
                <input type="checkbox" name="tag_ids[]" value="<?php echo $tag['id']; ?>" <?php echo in_array($tag['id'], $article['tag_ids']) ? 'checked' : ''; ?>>
                <label for="tag_<?php echo $tag['id']; ?>"><?php echo htmlspecialchars($tag['tag_name']); ?></label>
            </div>
        <?php endforeach; ?>

        <button type="submit"><?php echo $action === 'add' ? '添加文章' : '保存更改'; ?></button>
        <a href="../manage_articles.php">返回文章列表</a>
    </form>
</body>
</html>