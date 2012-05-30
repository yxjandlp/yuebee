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
    <b style="color:red">第一步</b>&gt;第二步&gt;第三步
    <div id="step_1" class="">
        <p>系统会给您的注册邮箱发一封带有验证码的邮件</p>
        <form name="forget_pwd_1" action="" method="post" id="forget_pwd_1">
            注册邮箱：<input type="text" name="pwd_email" id="pwd_email" value="<?php echo set_value('pwd_email')?>"/>
            <input type="submit" name="pwd_submit_1" id="pwd_submit_1" value="确定"/>
        </form>
        <b id="pwd_email_error" class="error_msg"><?php echo form_error('pwd_email',"<span>","</span>");?></b>
    </div>
