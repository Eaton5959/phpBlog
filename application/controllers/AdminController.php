<?php

// application/controllers/AdminController.php

require_once __DIR__ . '/../models/ArticleModel.php';
require_once __DIR__ . '/../models/TagModel.php';
require_once __DIR__ . '/../config/database.php';

class AdminController {
    private $articleModel;
    private $tagModel;

    public function __construct()
    {
        $db = createDatabaseConnection();
        $this->articleModel = new ArticleModel($db);
        $this->tagModel = new TagModel($db);
    }

    // 显示文章列表页面
    public function manageArticlesAction()
    {
        $articles = $this->articleModel->getAllArticles();
        require_once '../views/admin/manage_articles.php';
        exit;
    }

    // 添加文章处理函数
    public function addArticleAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            $tag_ids = isset($_POST['tag_ids']) ? array_map('intval', $_POST['tag_ids']) : [];

            // 验证数据有效性，并添加文章
            if (!empty($title) && !empty($content)) {
                $article_id = $this->articleModel->addArticle($title, $content, 1 /* 假设当前登录用户ID */ , $tag_ids);
                header("Location: ../admin/manage_articles.php");
                exit;
            } else {
                $errorMessage = "标题和内容不能为空！";
                require_once '../views/admin/add_article.php'; // 引入错误消息并重新显示表单
                exit;
            }
        } else {
            require_once '../views/admin/add_article.php';
            exit;
        }
    }

    // 编辑文章处理函数
    public function editArticleAction($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            $tag_ids = isset($_POST['tag_ids']) ? array_map('intval', $_POST['tag_ids']) : [];

            // 验证数据有效性，并更新文章
            if (!empty($title) && !empty($content)) {
                $this->articleModel->updateArticle($id, $title, $content, $tag_ids);
                header("Location: ../admin/manage_articles.php");
                exit;
            } else {
                $errorMessage = "标题和内容不能为空！";
            }
        } else {
            $article = $this->articleModel->getArticleById((int)$id);
            require_once '../views/admin/edit_article.php'; // 引入文章信息和错误消息（如果存在）
            exit;
        }
    }

    // 删除文章处理函数
    public function deleteArticleAction($id)
    {
        $this->articleModel->deleteArticle($id);
        header("Location: ../admin/manage_articles.php");
        exit;
    }

    // 标签相关的处理函数...
    // （根据需要实现类似的文章管理部分）

    // 在主入口或路由部分调用相应的方法
    public function handleAdminRequest()
    {
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'manage':
                    $this->manageArticlesAction();
                    break;
                case 'add':
                    $this->addArticleAction();
                    break;
                case 'edit':
                    if (isset($_GET['id'])) {
                        $this->editArticleAction((int)$_GET['id']);
                    }
                    break;
                case 'delete':
                    if (isset($_GET['id'])) {
                        $this->deleteArticleAction((int)$_GET['id']);
                    }
                    break;
                // 标签操作对应的case语句...
            }
        }
    }
}

// 示例：在主入口或其他合适的地方调用handleAdminRequest方法处理请求
// $adminController = new AdminController();
// if (/* 检查是否是管理员权限 */) {
//     $adminController->handleAdminRequest();
// } else {
//     // 跳转到未授权页面或返回错误提示
// }

?>