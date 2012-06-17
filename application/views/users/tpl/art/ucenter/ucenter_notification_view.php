<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 6/2/12
 * Time: 11:58 AM
 *
 * 个人中心消息界面
 *
 */
?>
<div class="block_menu">
    <ul>
        <li id="system_note"><a href="<?php echo site_url('ucenter/notification/system')?>">系统信息<?php echo $system_num == 0? "":"(".$system_num.")";?></a></li>
        <li id="friend_note"><a href="<?php echo site_url('ucenter/notification/friend')?>">新增粉丝<?php echo $request_num == 0? "":"(".$request_num.")";?></a></li>
        <li id="comment_note"><a href="<?php echo site_url('ucenter/notification/comment')?>">评论回复<?php echo $comment_num == 0? "":"(".$comment_num.")";?></a></li>
    </ul>
    <script type="text/javascript">
        <!--
        var notification_link = document.getElementById('<?php echo $type;?>_note');
        notification_link.className = "cur";
        //-->
    </script>
</div>
<div class="clear"></div>
<div id="notification_area">
    <?php foreach( $notifications as $notification ):?>
    <div class="notification_item">
        <img src="<?php echo site_url('avatar/get/'.$notification->from_uid.'/'.md5($notification->from_nickname).'/50/'.rand());?>" alt="avatar" width="50" height="50"/>
        <span>
            <?php echo $notification->note;?>
        </span>
    </div>
    <?php endforeach;?>
</div>