<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 6/3/12
 * Time: 4:28 PM
 *
 * 个人主页状态界面
 *
 */
?>
<div id="user_status">
<h4 style="border-bottom: 1px dotted #D3D3D3;">我的新鲜事：</h4>
<?php foreach( $statuses as $status ):?>
<div class="status_item">
    <div class="user_status_main">
        <div class="status_main_content">
            <span class="status_message"><?php echo $status->message;?></span><br/>
        </div>
        <p>
            <?php if( date('Y-m-d',time()) == date('Y-m-d',$status->create_time)):?>
            <?php echo date('今天 H:i:s',$status->create_time);?>
            <?php else:?>
            <?php echo date('Y-m-d H:i:s',$status->create_time);?>
            <?php endif;?>
            <span class="unfold_comment" style="float:right;"><a href="javascript:void(0);">回复<?php echo $status->reply_num == 0?"":"(".$status->reply_num.")";?></a></span>
            <span class="feed_id" name="<?php echo $status->fid;?>" style="display: none"></span>
        </p>
        <div class="clear"></div>
        <div class="comment_container">
            <?php if( $type == "reply" ):?>
            <?php foreach( $comments as $comment ):?>
                <div class='comment_item'>
                    <div class='comment_avatar'> <img src='<?php echo site_url('avatar/get/'.$comment->author_id.'/'.md5($comment->author_nickname).'/30/'.rand());?>' height='30' width='30' /></div>
                    <div class='comment_main'>
                        <a href='' class='reply_nickname'><?php echo $comment->author_nickname;?></a><?php echo $comment->comment;?>
                    </div>
                    <p><span class='reply' style='float:right;display: none;'><a href='javascript:void(0);' name="<?php echo $status->fid;?>">回复</a></span></p>
                    <div class='clear'></div>
                </div>
                <?php endforeach;?>
            <?php endif;?>
        </div>
        <div class="comment">
            <textarea autocomplete="off" class="status_comment user_status_comment" placeholder="评论..." id="textarea_<?php echo $status->fid;?>"></textarea>
            <div class="comment_action"  style="display: none;">
                <a class="cancel_comment" href="javascript:void(0);">取消</a>&nbsp;&nbsp;
                <a class="submit_comment" href="javascript:void(0);">发表</a>
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<?php endforeach;?>
</div>
</div>