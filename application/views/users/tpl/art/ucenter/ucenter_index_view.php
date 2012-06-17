<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 5/30/12
 * Time: 9:05 PM
 *
 * 个人中心默认页
 *
 */
?>


        <div id="input_text">
            <textarea id="feed_textarea" placeholder="最近发生了什么新鲜事..."></textarea>
            <div id="status_action">
                <span></span>
                <a href="javascript:void(0);" id="publish_status">
                    发布
                </a>
            </div>
            <div class="clear"></div>
        </div>
        <div id="feed_menu">
            <p>
                <a href="" style="float:left;">新鲜事</a>
                <span style="float:right;">
                    <a href="">好友分享</a>|<a href="">特别关注</a>
                </span>
            </p>
        </div>
        <div class="uc_center_content">
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
                                <a href='<?php echo site_url('users/'.$feed['first_comment']->author_id.'/'.$feed['first_comment']->author_nickname);?>' class='reply_nickname'><?php echo $feed['first_comment']->author_nickname;?></a> : <?php echo $feed['first_comment']->comment;?>
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
                                <a href='<?php echo site_url('users/'.$feed['last_comment']->author_id.'/'.$feed['last_comment']->author_nickname);?>' class='reply_nickname'><?php echo $feed['last_comment']->author_nickname;?></a> : <?php echo $feed['last_comment']->comment;?>
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


