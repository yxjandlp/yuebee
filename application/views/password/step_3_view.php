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
    第一步&gt;第二步&gt;<b style="color:red">第三步</b>
    <div id="step_3" class="">
        <form name="forget_pwd_3" action="" method="post" id="forget_pwd_3">
            <table border="0" width="500">
                <tr>
                    <td style="text-align: right">新密码&nbsp;:</td>
                    <td><input type="password" name="password" id="forget_pwd" value="<?php echo set_value('password');?>"/><br /></td>
                    <td style="width:150px;"><b class="error_msg" id="forget_pwd_msg"><?php echo form_error('password',"<span>","</span>");?>&nbsp;</b></td>
                </tr>
                <tr>
                    <td style="text-align: right">再次输入密码&nbsp;:</td>
                    <td><input type="password" name="password2" id="forget_pwd_2" value="<?php echo set_value("password2");?>"/><br /></td>
                    <td style="width:150px;"><b class="error_msg" id="forget_pwd2_msg"><?php echo form_error('password2',"<span>","</span>");?>&nbsp;</b></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><input type="submit" name="pwd_submit_3" id="pwd_submit_3" value="确定" /></td>
                </tr>
            </table>
        </form>
    </div>
