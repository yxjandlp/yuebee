<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 4/27/12
 * Time: 2:41 PM
 *
 * 登录界面
 *
 */
?>
    <br />
    还没有帐号？马上去<?php echo anchor(site_url('accounts/register'),"注册")?>吧
    <div class="registration_form">
        <div id="login_msg" class="<?php echo $error_class;?>">
            <p id="login_error_msg" class="error_msg"><?php echo $error_msg;?></p>
        </div>
        <form method="post" id="login_frm" action="<?php echo site_url('accounts/login');?>" name="login_frm">
            <div class="form_item">
                <div class="registration_left">
                    帐&nbsp;&nbsp;&nbsp;号 :
                </div>
                <div class="registration_center">
                    <input name="login_email" class="input_text" placeholder="您的邮箱" value="<?php echo $email;?>" id="login_email" />
                </div>
                <div class="registration_right">
                    <b id='login_email_msg' class="error_msg"></b>
                </div>
                <div class="clear"></div>
            </div>
            <div class="form_item">
                <div class="registration_left">
                    密&nbsp;&nbsp;&nbsp;码 :
                </div>
                <div class="registration_center">
                    <input name="login_pwd" type="password" class="input_text" id="login_pwd" placeholder="您的密码" value="<?php echo $password;?>">&nbsp;&nbsp;
                </div>
                <div class="registration_right">
                    <b id="login_pwd_msg" class='error_msg'></b>
                </div>
                <div class="clear"></div>
            </div>
            <div class="form_item">
                <div class="registration_left">
                    &nbsp;
                </div>
                <div class="registration_center">
                    <input name="login" value="登录" type="submit">&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $pwd_url;?>">忘记密码?</a>
                </div>
                <div class="registration_right">
                    <input type="hidden" name="referer_url"  value="<?php
                    if(isset($_SERVER['HTTP_REFERER']))
                        echo $_SERVER['HTTP_REFERER'];//设为前一页的url
                    ?>" />
                </div>
                <div class="clear"></div>
            </div>
        </form>