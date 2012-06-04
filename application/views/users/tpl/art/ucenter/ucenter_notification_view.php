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
        <li id="friend_note"><a href="<?php echo site_url('ucenter/notification/friend')?>">好友请求<?php echo $request_num == 0? "":"(".$request_num.")";?></a></li>
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
        <img src="<?php echo base_url('static/img/avatar/default.jpg');?>" alt="avatar" width="60" height="60" style="float:left;"/>
        &nbsp;&nbsp;&nbsp;<?php echo $notification->note;?>
        &nbsp;&nbsp;&nbsp;
        <?php if( $type == "friend"):?>
        <span id="accept_btn_<?php echo $notification->id;?>"><a href="javascript:void(0);" name="<?php echo $notification->id;?>">同意请求</a></span>
        <?php endif;?>
    </div>
    <?php endforeach;?>
</div>