/*
 * @Author: Eaton5959 eaton5959@163.com
 * @Date: 2024-02-03 02:26:19
 * @LastEditors: Eaton5959 eaton5959@163.com
 * @LastEditTime: 2024-02-03 02:26:23
 * @FilePath: \blog_app\public\js\admin_scripts.js
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */
// admin_scripts.js

document.addEventListener('DOMContentLoaded', function() {
    // 使表格行在鼠标悬停时变色
    const tableRows = document.querySelectorAll('table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseover', () => row.style.backgroundColor = '#dfe9f3');
        row.addEventListener('mouseout', () => row.style.backgroundColor = '');
    });

    // 添加文章按钮点击事件（假设添加文章按钮ID为'addArticleBtn'）
    document.getElementById('addArticleBtn').addEventListener('click', function(e) {
        e.preventDefault();
        location.href = '?action=add'; // 跳转到添加文章页面
    });
});

// 如果有表单提交操作，可以添加验证或防止重复提交等逻辑
// ...

// 如果有动态加载数据的需求，可以添加Ajax请求相关逻辑
// ...