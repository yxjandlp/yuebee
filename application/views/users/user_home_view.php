<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 5/3/12
 * Time: 3:28 PM
 *
 * 用户空间
 *
 */
?>
<img src="<?php echo site_url('avatar/get/'.$uid.'/'.md5($nickname).'/150/'.rand());?>" height="150" width="150" /><br />
<b><?php echo $user_info->nickname;?></b><br />

<div id="add_friend_link"><a href="javascript:void(0);" name="" >＋加为好友</a></div>
<input type="hidden" value="<?php echo $user_info->uid;?>" id="to_id" />
