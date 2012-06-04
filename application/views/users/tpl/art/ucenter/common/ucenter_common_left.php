<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 6/3/12
 * Time: 3:17 PM
 *
 * 个人中心左侧界面
 *
 */
?>
<div id="content_left">
    <div id="left_side">
        <a href="<?php echo site_url('users/'.$user_info->uid."/".$user_info->nickname);?>"><img src="<?php echo site_url('avatar/get/'.$user_info->uid.'/'.md5($user_info->nickname).'/150/'.rand());?>" height="100" width="100" style="border: 3px solid white;"/></a>
        <p id="nickname"><!--<img src="<?php echo base_url('static/img/tpl/art/sex.png');?>" width="17" height="20"/>--> <?php echo anchor(site_url('users/'.$user_info->uid."/".$user_info->nickname),$user_info->nickname);?></p>
        <ul id="left_nav">
            <li><a href="<?php echo site_url('ucenter')?>"><img src="<?php echo base_url('static/img/tpl/art/new_feed.png');?>" alt="新鲜事" /> 新鲜事</a> </li>
            <li><a href="<?php echo site_url('ucenter/status')?>"><img src="<?php echo base_url('static/img/tpl/art/about_me.png');?>" alt="与我相关" /> 与我相关</a> </li>
            <!--<li><a href="<?php echo site_url('ucenter/friend');?>"><img src="<?php echo base_url('static/img/tpl/art/photo.png');?>" alt="好友" /> 好友</a> </li>-->
            <li><a href=""><img src="<?php echo base_url('static/img/tpl/art/share.png');?>" alt="分享" /> 分享</a> </li>
            <li><a href="<?php echo site_url('ucenter/notification/system')?>"><img src="<?php echo base_url('static/img/tpl/art/message.png');?>" alt="消息" /> 消息<?php echo $notification_num == 0?"":"(".$notification_num.")";?></a> </li>
            <li><a href=""><img src="<?php echo base_url('static/img/tpl/art/my_novel.png');?>" alt="我的小说" /> 小说收藏</a> </li>
            <li><a href=""><img src="<?php echo base_url('static/img/tpl/art/forum.png');?>" alt="论坛" /> 论坛</a> </li>
        </ul>
    </div>
</div>
<div id="content_center">