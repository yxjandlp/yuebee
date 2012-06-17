<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 5/1/12
 * Time: 6:16 PM
 *
 * 模板header
 *
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $title;?></title>
    <link rel="SHORTCUT ICON" href="<?php echo base_url('static/img/favicon.ico');?>">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('static/css/yuebee.css');?>">
    <script type="text/javascript" src="<?php echo base_url('static/js/jquery-min.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('static/js/yuebee_main.js');?>"></script>
</head>
<body>
<div id="main" class="main">
    <div id="top_menu">
        <?php if( ! $is_logined ):?>
        <ul>
            <li><a href="<?php echo site_url('accounts/register/'); ?>">注册</a></li>
            <li><a href="<?php echo site_url('accounts/login/'); ?>">登录 |&nbsp;</a></li>
        </ul>
        <?php else:?>
        <ul>
            <li><?php echo anchor(site_url('accounts/login/logout'),'退出')?></li>
            <li id="show_notification"><a href="<?php echo site_url('ucenter/notification/system');?>">消息(<span id="num_of_notification">0</span>)</a>&nbsp;|&nbsp;</li>
            <li>欢迎您，<?php echo anchor(site_url('ucenter/'),$nickname );?> &nbsp;|&nbsp;</li>
        </ul>
        <?php endif;?>
    </div>
    <div class="clear"></div>
    <h1 class="banner"><?php echo anchor(site_url('/'),"约笔","class='title'");?></h1>
    <hr />
