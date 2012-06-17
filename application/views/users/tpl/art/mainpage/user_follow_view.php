<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 6/5/12
 * Time: 12:39 AM
 *
 * 关注列表界面
 *
 */
?>
<div id="user_friend_block">
    <h4 style="border-bottom: 1px dotted #D3D3D3;margin-bottom: 10px;">关注列表</h4>
    <?php foreach( $followes as $follow ):?>
    <div class="friend_item">
        <img src="<?php echo site_url('avatar/get/'.$follow->fid.'/'.md5($follow->fnickname).'/50');?>" alt="avatar" width="50" height="50" style="float:left;"/>
        <span class="friend_nickname"><a href="<?php echo site_url('users/'.$follow->fid);?>"> <?php echo $follow->fnickname;?></a></span>
    </div>
    <?php endforeach;?>
</div>
</div>