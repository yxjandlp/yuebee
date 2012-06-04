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
    <form name="change_pwd_frm" id="change_pwd_frm" method="post" action="">
        <table border="0" class="basic_profile_tb">
            <tr>
                <td style="text-align: right;">当前密码:</td>
                <td><input type="password" name="old_pwd" id="old_pwd"/></td>
            </tr>
            <tr>
                <td style="text-align: right;">新密码:</td>
                <td><input type="password" name="new_pwd" id="new_pwd" /> </td>
            </tr>
            <tr>
                <td style="text-align: right;">确认密码:</td>
                <td><input type="password" name="confirm_new_pwd" id="confirm_new_pwd" /> </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" value="保存新密码" /></td>
            </tr>
        </table>
    </form>