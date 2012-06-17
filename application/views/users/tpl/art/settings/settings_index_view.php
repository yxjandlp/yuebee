<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 6/4/12
 * Time: 12:10 PM
 *
 * 个人资料设置界面
 *
 */
?>
<h4 style="border-bottom: 1px dotted #D3D3D3;margin-bottom: 30px;">基本信息 <b style="color: #a9a9a9;font-size: 80%;">( <b class="focus">*</b> 号为必填项)</b></h4>
<div class="profile_admin">
    <form action="" method="post" name="basic_profile_frm" id="basic_profile_frm">
        <table border="0" class="basic_profile_tb">
            <tr>
                <td style="text-align: right;"><b class="focus">*</b> 昵称:</td>
                <td><input type="text" name="profile_nickname" id="profile_nickname" value="<?php echo $user_info->nickname;?>"/><br /></td>
                <td>
                    <b id ="nickname_error_msg" class='error_msg'></b>
                </td>
            </tr>
            <tr>
                <td style="text-align: right;">真实姓名:</td>
                <td><input type="text" name="real_name" /></td>
            </tr>
            <tr>
                <td style="text-align: right;"><b class="focus">*</b> 性别:</td>
                <td>
                    <label class="labelRadio" for="gender2">
                        <input id="gender2" type="radio" checked="checked" value="男生" name="gender">
                        男
                    </label>
                    <label class="labelRadio" for="gender1">
                        <input id="gender1" type="radio" value="女生" name="gender">
                        女
                    </label>
                </td>
            </tr>
            <tr>
                <td style="text-align: right;">生日:</td>
                <td>
                    <select name="birth_year" id="bir_thyear" onchange="showbirthday();">
                        <option value="0">年</option>
                        <?php for($i=$year;$i>=1960;$i--):?>
                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                        <?php endfor; ?>
                    </select>
                    <select name="birth_month" id="birth_month" onchange="showbirthday();">
                        <option value="0">月</option>
                        <?php for($i=1;$i<=12;$i++): ?>
                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                        <?php endfor; ?>
                    </select>
                    <select name="birth_day" id="birth_day">
                        <option value="0">日</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td style="text-align: right;">家乡:</td>
                <td>
                    <select name="home_province" class="home" id="home_province">
                        <option value="0">省份</option>
                        <?php foreach( $provinces as $province ):?>
                        <option value="<?php echo $province->id?>"><?php echo $province->name;?></option>
                        <?php endforeach;?>
                    </select>
                    <select name="home_city" id="home_city" style="display: none;"></select>
                </td>
            </tr>
            <tr>
                <td style="text-align: right;">现居地:</td>
                <td>
                    <select name="live_province" class="live" id="live_province">
                        <option value="0">省份</option>
                        <?php foreach( $provinces as $province ):?>
                        <option value="<?php echo $province->id?>"><?php echo $province->name;?></option>
                        <?php endforeach;?>
                    </select>
                    <select name="live_city" id="live_city" style="display: none;"></select>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">自我描述:</td>
                <td><textarea rows="5" cols="40"></textarea></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" value="确定" />&nbsp;&nbsp;<input type="button" value="取消" /></td>
            </tr>
        </table>
    </form>
</div>