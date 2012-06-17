<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 6/4/12
 * Time: 12:48 AM
 *
 * 粉丝列表界面
 *
 */
?>
    <div id="user_friend_block">
        <h4 style="border-bottom: 1px dotted #D3D3D3;margin-bottom: 10px;">粉丝列表</h4>
        <?php foreach( $fanses as $fans ):?>
        <div class="friend_item">
            <img src="<?php echo site_url('avatar/get/'.$fans->uid.'/'.md5($fans->unickname).'/50');?>" alt="avatar" width="50" height="50" style="float:left;"/>
            <span class="friend_nickname"><a href="<?php echo site_url('users/'.$fans->uid);?>"> <?php echo $fans->unickname;?></a></span>
        </div>
        <?php endforeach;?>
    </div>
</div>