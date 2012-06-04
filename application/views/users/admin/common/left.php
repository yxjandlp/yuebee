<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 5/11/12
 * Time: 5:48 PM
 *
 * 个人中心管理左侧内容
 *
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $title;?></title>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('static/css/yuebee.css');?>">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('static/css/jquery.Jcrop.css');?>">
    <script type="text/javascript" src="<?php echo base_url('static/js/jquery-min.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('static/js/jquery.form.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('static/js/yuebee_ucenter.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('static/js/jquery.Jcrop.min.js')?>"></script>
</head>
<body>
<div id="main" class="main">
    <h1 class="banner"><?php echo anchor(site_url('/'),"约笔","class='title'");?></h1>
    <hr />
    <div id="uc_main">
        <div id="uc_lt">
            <div id="sider_lt">
                <div class="user_info">
                    <img src="<?php echo site_url('avatar/get/'.$user_info->uid.'/'.md5($user_info->nickname).'/50');?>" height="50" width="50" class="avatar" />
                    <span class="operation"><a href="<?php echo site_url('ucenter/admin');?>"><h2>个人中心管理</h2></a></span>
                    <div class="clear"></div>
                    <div id="top_nickname"><?php echo anchor(site_url('ucenter'),$user_info->nickname);?><br /></div>
                </div>
                <div class="uc_lt_menu">
                    <ul>
                        <li id="profile_action" class=""><a href="<?php echo site_url('ucenter/admin/profile')?>">个人资料</a></li>
                        <li id="avatar_action" class=""><a href="<?php echo site_url('ucenter/admin/avatar');?>">更换头像</a></li>
                        <li id="favorite_action" class=""><a href="">修改密码</a></li>
                    </ul>
                    <script type="text/javascript">
                        <!--
                        var current_action = document.getElementById('<?php echo $current_action;?>_action');
                        current_action.className = "uc_lt_current";
                        //-->
                    </script>
                </div>
            </div>
        </div>
        <div id="uc_admin_center">