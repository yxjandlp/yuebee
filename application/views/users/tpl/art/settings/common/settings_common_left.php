<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 6/4/12
 * Time: 12:50 PM
 *
 * 帐号设置左侧界面
 *
 */
?>
<div id="settings_main">
    <div id="settings_left">
        <h3>帐号设置</h3>
        <div class="border">
            <dl>
                <dt>
                    <a href="<?php echo site_url('accounts/settings/index');?>" id="profile_block">
                        <img src="<?php echo base_url('static/img/tpl/'.$tpl_name.'/profile.png');?>" style="float:left;"/>
                        &nbsp;个人资料
                    </a>
                </dt>
                <dd>
                    <a href="<?php echo site_url('accounts/settings/index');?>" id="index_link">基本信息</a>
                </dd>
                <dd>
                    <a href="<?php echo site_url('accounts/settings/edu');?>" id="edu_link">教育信息</a>
                </dd>
            </dl>
        </div>
        <div class="border">
            <dl>
                <dt>
                    <a href="<?php echo site_url('accounts/settings/avatar');?>" id="avatar_block">
                        <img src="<?php echo base_url('static/img/tpl/'.$tpl_name.'/change_avatar.png');?>" style="float:left;"/>
                        &nbsp;修改头像
                    </a>
                </dt>
            </dl>
        </div>
        <div>
            <dl>
                <dt>
                    <a href="<?php echo site_url('accounts/settings/password');?>" id="safe_block">
                        <img src="<?php echo base_url('static/img/tpl/'.$tpl_name.'/account_safe.png');?>" style="float:left;"/>
                        &nbsp;帐号安全
                    </a>
                </dt>
                <dd>
                    <a href="<?php echo site_url('accounts/settings/password');?>" id="password_link">修改密码</a>
                </dd>
            </dl>
        </div>
        <script type="text/javascript">
            <!--
            <?php if( $current_block != "avatar"):?>
            var current_link = document.getElementById('<?php echo $current_app;?>_link');
            current_link.className = "dd_current";
            <?php endif;?>
            var current_block = document.getElementById('<?php echo $current_block;?>_block');
            current_block.className = "dt_current";
            //-->
        </script>
    </div>
    <div id="settings_center">
