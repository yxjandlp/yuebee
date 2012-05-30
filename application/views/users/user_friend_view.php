<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 5/5/12
 * Time: 5:56 PM
 *
 * 用户好友界面
 *
 */
?>


    <div id="friend_area">
        <div class="friend_top_menu">全部好友</div>
        <?php foreach( $friends as $friend ):?>
            <div class="friend_item">
                <img src="<?php echo site_url('avatar/get/'.$friend->fid.'/'.md5($friend->fnickname).'/50');?>" alt="avatar" width="50" height="50" style="float:left;"/>
                <span class="friend_nickname"><a href="<?php echo site_url('users/'.$friend->fnickname);?>"> <?php echo $friend->fnickname;?></a></span>
            </div>
        <?php endforeach;?>
    </div>



