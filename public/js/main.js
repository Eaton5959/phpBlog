/*
 * @Author: Eaton5959 eaton5959@163.com
 * @Date: 2024-02-03 01:57:55
 * @LastEditors: Eaton5959 eaton5959@163.com
 * @LastEditTime: 2024-02-03 01:58:01
 * @FilePath: \blog_app\public\js\main.js
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */
// public/js/main.js

document.addEventListener('DOMContentLoaded', function() {
    // 页面加载完成后执行的操作，例如：
    
    // 示例：为所有文章标题添加点击事件监听器（这里假设跳转到详情页）
    const articleTitles = document.querySelectorAll('main article h2 a');
    articleTitles.forEach(function(title) {
        title.addEventListener('click', function(event) {
            event.preventDefault(); // 阻止默认的链接跳转行为
            
            // 获取文章ID并进行跳转
            const id = this.getAttribute('href').split('=')[1];
            window.location.href = 'article.php?id=' + id;
        });
    });
});

// 如果有其他JavaScript交互逻辑，可以在此处添加