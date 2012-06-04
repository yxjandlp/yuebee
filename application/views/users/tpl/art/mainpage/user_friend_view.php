<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 6/4/12
 * Time: 12:48 AM
 *
 * 个人主页好友界面
 *
 */
?>
    <div id="user_friend_block">
        <h4 style="border-bottom: 1px dotted #D3D3D3;margin-bottom: 10px;">好友列表</h4>
        <?php foreach( $friends as $friend ):?>
        <div class="friend_item">
            <img src="<?php echo site_url('avatar/get/'.$friend->fid.'/'.md5($friend->fnickname).'/50');?>" alt="avatar" width="50" height="50" style="float:left;"/>
            <span class="friend_nickname"><a href="<?php echo site_url('users/'.$friend->fid);?>"> <?php echo $friend->fnickname;?></a></span>
        </div>
        <?php endforeach;?>
    </div>
</div>