<?php
// application/models/ArticleModel.php

require_once __DIR__ . '/../config/database.php';

class ArticleModel
{
    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    // 获取最新文章
    public function getLatestArticles($limit)
    {
        $sql = "SELECT * FROM articles ORDER BY created_at DESC LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 添加获取所有文章的方法
    public function getAllArticles()
    {
        $sql = "SELECT * FROM articles ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 根据标签ID获取相关文章
    public function getArticlesByTagId($tag_id)
    {
        // 假设有一个article_tags表来处理文章与标签的多对多关系
        $sql = "SELECT a.* FROM articles AS a 
                INNER JOIN article_tags AS at ON a.id = at.article_id
                INNER JOIN tags AS t ON t.id = at.tag_id
                WHERE t.id = :tag_id
                ORDER BY a.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':tag_id', $tag_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 获取单篇文章详情
    public function getArticleById($id)
    {
        $sql = "SELECT * FROM articles WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 添加文章（同时处理与标签的关联）
    public function addArticle($title, $content, $author_id, $tag_ids)
    {
        $sql = "INSERT INTO articles (title, content, author_id, created_at) VALUES (:title, :content, :author_id, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':author_id', $author_id);
        $stmt->execute();

        $article_id = $this->db->lastInsertId(); // 获取新插入文章的ID

        // 保存文章与标签的关系
        foreach ($tag_ids as $tag_id) {
            $this->addArticleTag($article_id, $tag_id);
        }
    }

    // 更新文章（同时处理与标签的关联）
    public function updateArticle($id, $title, $content, $tag_ids)
    {
        // 先删除旧的关联关系
        $this->deleteArticleTagsByArticleId($id);

        // 更新文章信息
        $sql = "UPDATE articles SET title = :title, content = :content WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // 保存新的文章与标签的关系
        foreach ($tag_ids as $tag_id) {
            $this->addArticleTag($id, $tag_id);
        }
    }

    // 删除文章及其与标签的关联
    public function deleteArticle($id)
    {
        $this->deleteArticleTagsByArticleId($id);
        $sql = "DELETE FROM articles WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    // 添加文章与标签的关联记录
    private function addArticleTag($article_id, $tag_id)
    {
        $sql = "INSERT INTO article_tags (article_id, tag_id) VALUES (:article_id, :tag_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':article_id', $article_id, PDO::PARAM_INT);
        $stmt->bindParam(':tag_id', $tag_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    // 删除指定文章与所有标签的关联关系
    private function deleteArticleTagsByArticleId($article_id)
    {
        $sql = "DELETE FROM article_tags WHERE article_id = :article_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':article_id', $article_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    // 获取特定文章的所有标签
    public function getTagsByArticleId($article_id)
    {
        // 假设有article_tags表，用于处理文章与标签的多对多关系
        $sql = "SELECT t.* FROM tags AS t 
                INNER JOIN article_tags AS at ON t.id = at.tag_id
                WHERE at.article_id = :article_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':article_id', $article_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
