<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 6/3/12
 * Time: 9:26 PM
 *
 * 个人主页右侧界面
 *
 */
?>
<div id="user_right">
    <?php if( ! $is_current )://访问除当前登录用户外的主页时?>
    <?php if( $follow_status == -1)://没有关注?>
        <div class="user_add_follow follow_block">
                <span class="follow">
                    <a href="javascript:void(0);" name="<?php echo $user_info->uid;?>" class="add_follow_link">
                        <span>
                            <b>+</b> 加关注
                        </span>
                    </a>
                </span>
        </div>
        <?php endif;?>
    <?php if( $follow_status == 0 )://已关注，但没有互相关注?>
        <div class="user_followed follow_block">
                <span class="followed">
                    <a href="javascript:void(0);" class="cancel_follow" name="<?php echo $user_info->uid;?>">
                        <span class="follow_main_text">正在关注</span>
                        <span class="follow_hover_text">取消关注</span>
                    </a>
                </span>
        </div>
        <?php endif;?>
    <?php if( $follow_status == 1 )://互相关注?>
        <div class="user_both_followed follow_block">
                <span class="followed">
                    <a href="javascript:void(0);" class="cancel_follow" name="<?php echo $user_info->uid;?>">
                        <span class="follow_main_text">互相关注</span>
                        <span class="follow_hover_text">取消关注</span>
                    </a>
                </span>
        </div>
        <?php endif;?>
    <?php else:?>
    <div class="user_right_block">
        <a href="<?php echo site_url('accounts/settings/index');?>" class="right_profile_edit">
            <img src="<?php echo base_url('static/img/tpl/'.$tpl_name.'/edit.png');?>" alt="编辑资料" style="float:left;"/>
            &nbsp;编辑资料
        </a>
    </div>
    <?php endif;?>
    <div id="user_liked_novel" class="user_right_block">
        <p>
            <a href="" class="right_block_title">
                关注的小说
            </a>
        </p>
        暂无关注的小说 ...
    </div>
    <div id="user_follow_block" class="user_right_block">
        <p>
            <a href="" class="right_block_title">
                关注(<?php echo $follow_num;?>)
            </a>
        </p>
        关注列表出现在这 ...
    </div>
    <div id="user_fans_block" class="user_right_block">
        <p>
            <a href="" class="right_block_title">
                粉丝(<?php echo $fans_num;?>)
            </a>
        </p>
        粉丝列表出现在这 ...
    </div>
</div>