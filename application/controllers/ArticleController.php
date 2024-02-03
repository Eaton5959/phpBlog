<?php
// application/controllers/ArticleController.php

require_once __DIR__ . '/../models/ArticleModel.php';
require_once __DIR__ . '/../models/TagModel.php';
require_once __DIR__ . '/../config/database.php';

class ArticleController {
    private $articleModel;
    private $tagModel;

    public function __construct()
    {
        $db = createDatabaseConnection();
        $this->articleModel = new ArticleModel($db);
        $this->tagModel = new TagModel($db);
    }

    // 显示首页，列出最新文章
    public function indexAction()
    {
        $latestArticles = $this->articleModel->getLatestArticles(10);
        require_once '../views/frontend/index.php';
        exit;
    }

    // 显示根据标签筛选的文章页面
    public function tagsAction()
    {
        $tag_id = $_GET['id'] ?? 0;
        if ($tag_id <= 0) {
            header("Location: /"); // 如果没有标签ID，则重定向到首页
            exit;
        }
        
        $articlesWithTag = $this->articleModel->getArticlesByTagId($tag_id);
        require_once '../views/frontend/tags.php';
        exit;
    }

    // 显示文章详情页面
    public function viewAction()
    {
        $article_id = $_GET['id'] ?? 0;
        if ($article_id <= 0) {
            header("Location: /"); // 如果没有文章ID，则重定向到首页
            exit;
        }

        $article = $this->articleModel->getArticleById($article_id);
        if (empty($article)) {
            header("Location: /404.php"); // 如果文章不存在，则重定向到404页面
            exit;
        }

        require_once '../views/frontend/article.php';
        exit;
    }

    // 后台管理部分 - 文章列表
    public function manageArticlesAction()
    {
        $articles = $this->articleModel->getAllArticles();
        require_once '../views/admin/manage_articles.php';
        exit;
    }

    // 后台管理部分 - 添加文章处理函数
    public function addEditArticleAction()
    {
        $action = $_GET['action'] ?? '';
        $article_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 处理表单提交逻辑...
        } else {
            if ($action === 'edit' && $article_id > 0) {
                $article = $this->articleModel->getArticleById($article_id);
                $tags = $this->tagModel->getTagsByArticleId($article_id);
            } else {
                $article = [
                    'title' => '',
                    'content' => '',
                    'tag_ids' => [],
                ];
                $tags = $this->tagModel->getAllTags(); // 获取所有标签供选择
            }
            
            require_once '../views/admin/add_edit_article.php';
            exit;
        }
    }

    // ... 其他方法（如删除、编辑文章等）...

    // 在主入口或其他合适的地方调用相应的方法
    public function handleRequest()
    {
        // 根据实际路由规则处理请求并调用对应方法
        // 示例代码：
        // if (/* 判断当前请求路径为前端首页 */) {
        //     $this->indexAction();
        // } elseif (/* 判断当前请求路径为标签页 */) {
        //     $this->tagsAction();
        // } elseif (/* 判断当前请求路径为文章详情页 */) {
        //     $this->viewAction();
        // } elseif (/* 判断当前请求路径为后台管理-文章列表页 */) {
        //     $this->manageArticlesAction();
        // } elseif (/* 判断当前请求路径为后台管理-添加或编辑文章页 */) {
        //     $this->addEditArticleAction();
        // } else {
        //     // 处理其他路由或返回404错误
        // }
    }
}

// 示例：在主入口或其他合适的地方实例化并调用handleRequest方法处理请求
$articleController = new ArticleController();
$articleController->handleRequest();

?>