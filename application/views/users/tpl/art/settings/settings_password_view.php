<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 6/4/12
 * Time: 4:22 PM
 *
 * 修改密码界面
 *
 */
?>
<h4 style="border-bottom: 1px dotted #D3D3D3;margin-bottom: 30px;">修改密码</h4>
    <form name="change_pwd_frm" id="change_pwd_frm" method="post" action="<?php echo site_url('accounts/settings/password');?>">
        <table border="0" class="basic_profile_tb">
            <tr>
                <td style="text-align: right;">当前密码:</td>
                <td><input type="password" name="current_pwd" id="current_pwd" value="<?php echo set_value('current_pwd');?>"/></td>
                <td>
                    <b id="current_pwd_msg" class='error_msg'>
                        <?php echo form_error('current_pwd', '<span>', '</span>'); ?>
                    </b>
                </td>
            </tr>
            <tr>
                <td style="text-align: right;">新密码:</td>
                <td><input type="password" name="new_pwd" id="new_pwd" value="<?php echo set_value('new_pwd');?>" /> </td>
                <td>
                    <b id="new_pwd_msg" class="error_msg">
                        <?php echo form_error('new_pwd', '<span>', '</span>'); ?>
                    </b>
                </td>
            </tr>
            <tr>
                <td style="text-align: right;">确认密码:</td>
                <td><input type="password" name="confirm_new_pwd" id="confirm_new_pwd" value="<?php echo set_value('confirm_new_pwd');?>" /></td>
                <td>
                    <b id="confirm_new_pwd_msg" class="error_msg">
                        <?php echo form_error('confirm_new_pwd','<span>','</span>');?>
                    </b>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" value="保存" /></td>
            </tr>
        </table>
    </form>