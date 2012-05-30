<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 5/5/12
 * Time: 5:51 PM
 *
 * 用户中心左侧内容
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
    <script type="text/javascript" src="<?php echo base_url('static/js/yuebee_ucenter.js');?>"></script>
</head>
<body>
<div id="decoration_link">
    <a href="javascript:void(0);" title="模板设置">
        <img src="<?php echo base_url('static/img/close.png');?>" />
    </a>
</div>
<div id="absolute_top">
    <div id="tpl_action">
        <a href="javascript:void(0);" id="cancel_dec"><img src="<?php echo base_url('static/img/close_dec.png');?>" width="20" height="20"/> </a>
    </div>
    <div id="tpl_list">
        <div class="ucenter_tpl">
            <div class="ucenter_tpl_img">
                <a href="javascript:void(0);" class="tpl_select">
                    <img src="<?php echo base_url('static/img/tpl/tpl_art.png');?>" width="100" height="100"/>
                </a>
            </div>
            <div class="ucenter_tpl_title">
                文艺青年
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div id="main" class="main">
    <h1 class="banner"><?php echo anchor(site_url('/'),"约笔","class='title'");?></h1>
    <hr />
    <div id="uc_main">
        <div id="uc_lt">
            <div id="sider_lt">
                <div class="user_info">
                    <img src="<?php echo site_url('avatar/get/'.$user_info->uid.'/'.md5($user_info->nickname).'/50/'.rand());?>" height="50" width="50" class="avatar" />
                    <span class="operation">
                        <a href="<?php echo site_url('ucenter/admin/profile')?>">修改资料</a>&nbsp;
                        <a href="<?php echo site_url('ucenter/admin/avatar')?>">修改头像</a>
                    </span>
                    <div class="clear"></div>
                    <div id="top_nickname"><?php echo anchor(site_url('users/'.$user_info->uid."/".$user_info->nickname),$user_info->nickname);?><br /></div>
                </div>
                <div class="uc_lt_menu">
                    <ul>
                        <li id="news_link" class=""><a href="<?php echo site_url('ucenter')?>">新鲜事</a></li>
                        <li id="friend_link" class=""><a href="<?php echo site_url('ucenter/friend');?>">好友</a></li>
                        <li id="notification_link" class=""><a href="<?php echo site_url('ucenter/notification/system')?>">消息<?php echo $notification_num == 0?"":"(".$notification_num.")";?></a></li>
                        <li id="status_link" class=""><a href="<?php echo site_url('ucenter/status');?>">我的状态</a></li>
                        <li id="admin_link" class=""><a href="<?php echo site_url('ucenter/admin');?>">管理</a></li>
                    </ul>
                    <script type="text/javascript">
                        <!--
                        var current_link = document.getElementById('<?php echo $current_app;?>_link');
                        current_link.className = "uc_lt_current";
                        //-->
                    </script>
                </div>
            </div>
        </div>
        <div id="uc_center">
