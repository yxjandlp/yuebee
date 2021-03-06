<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 6/3/12
 * Time: 3:33 PM
 *
 * 个人主页左侧界面
 *
 */
?>
<div class="clear"></div>
<div id="user_mainpage">
    <div id="user_left">
        <a href="<?php echo site_url('accounts/settings/avatar');?>">
            <img src="<?php echo site_url('avatar/get/'.$user_info->uid.'/'.md5($user_info->nickname).'/150/'.rand());?>" height="150" width="150" />
        </a>
        <div class="uc_lt_menu">
            <ul>
                <li id="news_link" class="user_link">
                    <a href="<?php echo site_url('users/'.$user_info->uid.'/'.$user_info->nickname)?>">
                        <img src="<?php echo base_url('static/img/tpl/'.$tpl_name."/feeds.png"); ?>"/>
                        &nbsp;
                        <?php if( $is_current ):?>
                        我的新鲜事
                        <?php else:?>
                        他的新鲜事
                        <?php endif;?>
                    </a>
                </li>
                <li id="profile_link" class="user_link">
                    <a href="<?php echo site_url('profile/'.$user_info->uid.'/'.$user_info->nickname);?>">
                        <img src="<?php echo base_url('static/img/tpl/'.$tpl_name."/profile.png"); ?>"/>
                        &nbsp;&nbsp;个人资料
                    </a>
                </li>
                <li id="fans_link" class="user_link">
                    <a href="<?php echo site_url('fans/'.$user_info->uid.'/'.$user_info->nickname);?>">
                        <img src="<?php echo base_url('static/img/tpl/'.$tpl_name."/friend.png"); ?>"/>&nbsp;
                        粉丝(<?php echo $fans_num;?>)
                    </a>
                </li>
                <li id="follow_link" class="user_link">
                    <a href="<?php echo site_url('follow/'.$user_info->uid.'/'.$user_info->nickname);?>">
                        <img src="<?php echo base_url('static/img/tpl/'.$tpl_name."/follow.png"); ?>"/>&nbsp;
                        关注(<?php echo $follow_num;?>)
                    </a>
                </li>
                <li id="novel_link" class="user_link">
                    <a href="">
                        <img src="<?php echo base_url('static/img/tpl/'.$tpl_name."/novel.png"); ?>"/>
                        &nbsp;
                        <?php if( $is_current ):?>
                        我的小说
                        <?php else:?>
                        他的小说
                        <?php endif;?>
                    </a>
                </li>
            </ul>
            <script type="text/javascript">
                <!--
                var current_link = document.getElementById('<?php echo $current_app;?>_link');
                current_link.className = "uc_lt_current";
                //-->
            </script>
        </div>
    </div>
    <div id="user_center">
        <div id="user_title">
            <h2><?php echo $user_info->nickname;?></h2>

        </div>

