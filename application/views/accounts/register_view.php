<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 4/27/12
 * Time: 2:42 PM
 *
 * 注册界面
 *
 */
//session_start();
?>

    <br />
    已有帐号？马上去<?php echo anchor(site_url('accounts/login'),"登录")?>吧
    <div class="registration_form">
        <form name="reg_form" method="post" id="reg_form" action="<?php echo site_url('accounts/register/');?>">
            <div class="form_item">
                <span class="registration_left">
                    Email 地址：
                </span>
                <span class="registration_center">
                    <input name="email" class="input_text" id="email" type="text" value="<?php echo set_value('email');?>" />
                </span>
                <span class="registration_right">
                    <b id="email_error_msg" class='error_msg'><?php echo form_error('email', '<span>', '</span>'); ?></b>
                </span>
                <div class="clear"></div>
            </div>
            <div class="form_item">
                <span class="registration_left">
                    昵称：
                </span>
                <span class="registration_center">
                    <input name="nickname" id="nickname" class="input_text" type="text" value="<?php echo set_value('nickname');?>" />
                </span>
                <span class="registration_right">
                    <b id ="nickname_error_msg" class='error_msg'><?php echo form_error('nickname', '<span>', '</span>'); ?></b>
                </span>
                <div class="clear"></div>
            </div>

            <div class="form_item">
                <span class="registration_left">
                    密码：
                </span>
                <span class="registration_center">
                    <input name="password" id="reg_password" type="password" class="input_text" value="<?php echo set_value('password');?>"/>
                </span>
                <span class="registration_right">
                    <b id="password_error_msg" class='error_msg'><?php echo form_error('password', '<span>', '</span>'); ?></b>
                </span>
                <div class="clear"></div>
            </div>
            <div class="form_item">
                <span class="registration_left">
                    确认密码：
                </span>
                <span class="registration_center">
                    <input name="password2" id="reg_password2" type="password" class="input_text" value="<?php echo set_value('password2');?>"/>
                </span>
                <span class="registration_right">
                    <b id="password2_error_msg" class='error_msg'><?php echo form_error('password2', '<span>', '</span>'); ?></b>
                </span>
                <div class="clear"></div>
            </div>
            <div class="form_item">
                <span class="registration_left">
                    输入验证码：
                </span>
                <span class="registration_center">
                    <input name="code" type="text" class="input_text" size="6" id="code" value="<?php echo set_value('code')?>"/>
                    &nbsp;&nbsp;<a href="javascript:change_code();" id="change_code">换一张</a>
                </span>
                <span class="registration_right">
                    <b id="code_error_msg" class='error_msg'><?php echo form_error('code', '<span>', '</span>'); ?></b>
                </span>
                <div class="clear"></div>
            </div>
            <div class="form_item">
                <span class="registration_left">
                    &nbsp;
                </span>
                <span class="registration_center">
                    <img src="<?php echo site_url('show_captcha/');?>" id="code_img"  class="" alt="code_img" onclick="this.src='<?php echo site_url('show_captcha');?>'+'/index/'+Math.random()"/>
                </span>
                <span class="registration_right">

                </span>
                <div class="clear"></div>
            </div>
            <div class="form_item">
                <span class="registration_left">
                    &nbsp;
                </span>
                <span class="registration_center">
                    <input type="hidden" name="token" value="submit_token" />
                    <input name="register" value="注册" type="submit" class="input_text submit">
                </span>
                <span class="registration_right">

                </span>
                <div class="clear"></div>
            </div>
        </form>
    </div>

