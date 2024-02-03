<?php
/*
 * @Author: Eaton5959 eaton5959@163.com
 * @Date: 2024-02-03 01:49:31
 * @LastEditors: Eaton5959 eaton5959@163.com
 * @LastEditTime: 2024-02-03 02:56:14
 * @FilePath: \blog_app\application\models\TagModel.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */

// application/models/TagModel.php

require_once __DIR__ . '/../config/database.php';

class TagModel {
    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    // 添加标签
    public function addTag($tag_name)
    {
        $sql = "INSERT INTO tags (tag_name) VALUES (:tag_name)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':tag_name', $tag_name);
        $stmt->execute();
    }

    // 更新标签
    public function updateTag($id, $new_tag_name)
    {
        $sql = "UPDATE tags SET tag_name = :new_tag_name WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':new_tag_name', $new_tag_name);
        $stmt->execute();
    }

    // 删除标签
    public function deleteTag($id)
    {
        // 先删除与该标签关联的文章关系
        $this->deleteArticleTagsByTagId($id);

        $sql = "DELETE FROM tags WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    // 获取所有标签
    public function getAllTags()
    {
        $sql = "SELECT * FROM tags";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 根据ID获取单个标签
    public function getTagById($id)
    {
        $sql = "SELECT * FROM tags WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 添加获取特定文章关联的标签的方法
    public function getTagsByArticleId($article_id)
    {
        // 假设存在一个名为 article_tags 的中间表，用于处理文章与标签的多对多关系
        $sql = "SELECT t.* FROM tags AS t 
                JOIN article_tags AS at ON t.id = at.tag_id
                WHERE at.article_id = :article_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':article_id', $article_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 为文章添加标签（多对多关系）
    public function addArticleTag($article_id, $tag_id)
    {
        $sql = "INSERT INTO article_tags (article_id, tag_id) VALUES (:article_id, :tag_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':article_id', $article_id);
        $stmt->bindParam(':tag_id', $tag_id);
        $stmt->execute();
    }

    // 删除指定文章与标签的关联关系（多对多关系）
    public function deleteArticleTagsByArticleId($article_id)
    {
        $sql = "DELETE FROM article_tags WHERE article_id = :article_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':article_id', $article_id);
        $stmt->execute();
    }

    // 删除指定标签与所有文章的关联关系（多对多关系）
    private function deleteArticleTagsByTagId($tag_id)
    {
        $sql = "DELETE FROM article_tags WHERE tag_id = :tag_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':tag_id', $tag_id);
        $stmt->execute();
    }
}

?>