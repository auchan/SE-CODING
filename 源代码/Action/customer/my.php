<?php
session_start();

//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['username'])){
    header("Location:/../../login.html");
    exit();
}
echo '用户：' . $_SESSION['username'] . '<br />';
echo '系统升级中...<br />';
date_default_timezone_set('PRC');
echo date("Y-m-d") . ' ' . date('h:i:s A') . '<br />';
echo '操作员:admin<br />';
echo '<a href="../LoginAction.php?action=logout">注销</a> 登录<br />';
?>