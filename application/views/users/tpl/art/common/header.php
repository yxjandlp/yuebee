<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 6/4/12
 * Time: 12:26 PM
 *
 * header
 *
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $title;?></title>
    <!--[if IE 6]>
    <script src="<?php echo base_url('static/js/DD_belatedPNG.js');?>"></script>
    <script>
        /* EXAMPLE */
        DD_belatedPNG.fix('.round_menu,#round_bottom,#rec_novel,#rec_friend,#content img,#content,#top_center_menu,#top_center_menu_hack');
        /* string argument can be any CSS selector */
        /* .png_bg example is unnecessary */
        /* change it to what suits you! */
    </script>
    <![endif]-->
    <link rel="stylesheet/less" type="text/css" href="<?php echo base_url('static/css/tpl/art/main.less');?>">
    <script type="text/javascript" src="<?php echo base_url('static/js/less-1.3.0.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('static/js/jquery-min.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('static/js/yuebee_ucenter.js');?>"></script>
</head>
<body>
<div id="main">
    <div id="top">
        <div class="top_round_menu">
            <div class="round_menu" style="margin-right:10px">
                <a href="<?php echo site_url("ucenter");?>">
                    <p>空间</p>
                    <p>首页</p>
                </a>
            </div>
            <div class="round_menu">
                <a href="<?php echo site_url('users/'.$user_info->uid."/".$user_info->nickname)?>">
                    <p>个人</p>
                    <p>主页</p>
                </a>
            </div>
            <div class="clear"></div>
        </div>
        <div id="top_center">
            <div id="title">
                <div id="main_title">
                    约笔文学空间
                </div>
                <div id="side_title">
                    精灵空间
                </div>
            </div>
            <div id="top_center_menu">
                <div id="top_center_menu_hack">
                    <div id="top_menu_1">
                        <ul class="nav">
                            <li style="padding-left:5px;">
                                <a href="">武侠</a>
                            </li>
                            <li>
                                <a href="">玄幻</a>
                            </li>
                            <li>
                                <a href="">女生</a>
                            </li>
                            <li>
                                <a href="">言情</a>
                            </li>
                        </ul>
                    </div>
                    <div class="clear"></div>
                    <div id="top_menu_2">
                        <ul class="nav">
                            <li style="padding-left:5px;">
                                <a href="">灵异</a>
                            </li>
                            <li>
                                <a href="">悬疑</a>
                            </li>
                            <li>
                                <a href="">星座</a>
                            </li>
                            <li>
                                <a href="">微小说</a>
                            </li>
                            <li>
                                <a href="">文学</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="top_round_menu">
            <div class="round_menu" style="margin-right:10px">
                <p>好友</p>
                <p>搜索</p>
            </div>
            <div class="round_menu">
                <a href="<?php echo site_url('accounts/settings');?>">
                    <p>帐号</p>
                    <p>设置</p>
                </a>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div id="content">