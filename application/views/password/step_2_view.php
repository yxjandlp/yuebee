<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 5/1/12
 * Time: 12:43 AM
 *
 * 忘记密码第一步界面
 *
 */



?>

    <h3>忘记密码</h3>
    第一步&gt;<b style="color:red">第二步</b>&gt;第三步
    <div id="step_2" class="">
        <p>系统已给您的注册邮箱发了一封邮件，请登录邮箱获取验证码</p>
        <form name="forget_pwd_2" action="" method="post">
            验证码：<input type="text" name="pwd_captcha" value="<?php echo set_value('pwd_captcha')?>"/>
            <input type="submit" name="pwd_submit_2" id="pwd_submit_2" value="确定"/>
        </form>
        <b id="pwd_captcha_error" class="error_msg"><?php echo form_error('pwd_captcha',"<span>","</span>");?></b>
    </div>
