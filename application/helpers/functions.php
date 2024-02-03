<?php
/*
 * @Author: Eaton5959 eaton5959@163.com
 * @Date: 2024-02-03 03:24:36
 * @LastEditors: Eaton5959 eaton5959@163.com
 * @LastEditTime: 2024-02-03 20:25:14
 * @FilePath: \blog_app\application\helpers\functions.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */

function isAdminLoggedIn()
{
    // 开始会话（如果还没有开始）
    session_start();

    // 检查会话中是否有一个名为'admin_logged_in'的变量，并且它的值是true
    if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
        // 如果条件满足，返回true，表示管理员已登录
        return true;
    } else {
        // 如果条件不满足，返回false，表示管理员未登录
        return false;
    }
}
