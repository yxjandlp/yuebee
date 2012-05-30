<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 5/3/12
 * Time: 1:34 PM
 *
 * 用户的详细资料
 *
 */
?>

        <div id="status">
            状态
            <form action="" name="status_frm" id="status_frm" method="post">
                <div id="status_text">
                    <div class="num" style="display: none;">
                        还可输入
                        <span id="status_num">140</span>
                        个字
                    </div>
                    <textarea style="height: 55px;" node-type="textEl" name="status_content" tabindex="1" placeholder="最近发生了什么新鲜事..." id="status_content"></textarea>
                    <b class="error_msg"></b>
                    <div class="success_tip" style="display: none;"></div>
                </div>
                <div id="status_action">
                    <input type="submit" value="发布" class="publish_status"/>
                </div>
            </form>
        </div>
        <div class="uc_center_content">
            <div class="uc_center_menu">
                <a href="">全部新鲜事</a>
            </div>
            <?php foreach( $feeds as $feed ):?>
            <div class="status_item">
                <div class="status_avatar"><img src="<?php echo site_url('avatar/get/'.$feed['uid'].'/'.md5($feed['nickname']).'/50/'.rand());?>" alt="<?php echo $feed['nickname'];?>" width="50" height="50" class="status_avatar"/></div>
                <div class="status_main">
                    <div class="status_main_content">
                        <span class="status_author"><?php echo anchor(site_url('users/'.$feed['uid'].'/'.$feed['nickname']),$feed['nickname']);?></span> :
                        <span class="status_message"><?php echo $feed['message'];?></span><br/>
                    </div>
                    <p>
                        <?php if( date('Y-m-d',time()) == date('Y-m-d',$feed['create_time'])):?>
                        <?php echo date('今天 H:i:s',$feed['create_time']);?>
                        <?php else:?>
                        <?php echo date('Y-m-d H:i:s',$feed['create_time']);?>
                        <?php endif;?>
                        <?php if( $feed['feed_type'] != 2 ):?>
                        <span class="feed_id" name="<?php echo $feed['feed_id'];?>" style="display: none"></span>
                        <?php endif;?>
                    </p>
                    <?php if( $feed['feed_type'] != 2 ):?>
                    <div class="clear"></div>
                    <div class="comment_container">
                        <?php if($feed['reply_num'] >= 1 ):?>
                        <div class='comment_item'>
                            <div class='comment_avatar'> <img src='<?php echo site_url('avatar/get/'.$feed['first_comment']->author_id.'/'.md5($feed['first_comment']->author_nickname).'/30/'.rand());?>' height='30' width='30' /></div>
                            <div class='comment_main'>
                                <a href='' class='reply_nickname'><?php echo $feed['first_comment']->author_nickname;?></a><?php echo $feed['first_comment']->comment;?>
                            </div>
                            <p><span class='reply' style='float:right;display: none;'><a href='javascript:void(0);' name="<?php echo $feed['feed_id'];?>">回复</a></span></p>
                            <div class='clear'></div>
                        </div>
                        <?php endif;?>
                        <?php if($feed['reply_num'] >= 2 ):?>
                        <?php if($feed['reply_num'] > 2):?>
                            <div class="more_comment">
                                <a href="javascript:void(0);" name="<?php echo $feed['feed_id'];?>">还有<?php echo $feed['reply_num'] - 2;?>条回复</a>
                            </div>
                            <div id="more_<?php echo $feed['feed_id'];?>"></div>
                        <?php endif;?>
                        <div class='comment_item'>
                            <div class='comment_avatar'> <img src='<?php echo site_url('avatar/get/'.$feed['last_comment']->author_id.'/'.md5($feed['last_comment']->author_nickname).'/30/'.rand());?>' height='30' width='30' /></div>
                            <div class='comment_main'>
                                <a href='' class='reply_nickname'><?php echo $feed['last_comment']->author_nickname;?></a><?php echo $feed['last_comment']->comment;?>
                            </div>
                            <p><span class='reply' style='float:right;display: none;'><a href='javascript:void(0);' name="<?php echo $feed['feed_id'];?>">回复</a></span></p>
                            <div class='clear'></div>
                        </div>
                        <?php endif;?>
                    </div>
                    <div class="comment">

                        <textarea autocomplete="off" class="status_comment" placeholder="评论..." id="textarea_<?php echo $feed['feed_id'];?>"></textarea>
                        <div class="comment_action"  style="display: none;">
                            <a class="cancel_comment" href="javascript:void(0);">取消</a>&nbsp;&nbsp;
                            <a class="submit_comment" href="javascript:void(0);">发表</a>
                        </div>
                    </div>
                    <?php endif;?>
                </div>
                <div class="clear"></div>
            </div>
            <?php endforeach;?>
        </div>
        <div class="more">
            <a id="more" name="10" href="javascript:void(0);">查看更多动态</a>
        </div>


