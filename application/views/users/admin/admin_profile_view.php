<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 5/11/12
 * Time: 4:46 PM
 *
 * 编辑个人资料界面
 *
 *
 */
?>
<div class="admin_menu_top">
    <a href="<?php echo site_url('ucenter/');?>">个人中心</a> »
    <a href="<?php echo site_url('ucenter/admin');?>">管理</a> »
    <a href="<?php echo site_url('ucenter/admin/profile')?>">个人资料</a>
</div>
<div class="block_menu">
    <ul>
        <li id="basic_profile"><a href="<?php echo site_url('ucenter/admin/profile')?>">基本资料</a></li>
        <li id="edu_profile"><a href="<?php echo site_url('ucenter/admin/profile/edu')?>">教育信息</a></li>
    </ul>
    <script type="text/javascript">
        <!--
        var notification_link = document.getElementById('<?php echo $type;?>_profile');
        notification_link.className = "cur";
        //-->
    </script>
</div>
<div class="clear"></div>
<div class="profile_admin">
    <form action="" method="post" name="basic_profile_frm" id="basic_profile_frm">
        <table border="0" class="basic_profile_tb">
            <tr>
                <td style="text-align: right;">昵称:</td>
                <td><input type="text" name="nickname" /><br /></td>
            </tr>
            <tr>
                <td style="text-align: right;">真实姓名:</td>
                <td><input type="text" name="real_name" /></td>
            </tr>
            <tr>
                <td style="text-align: right;">性别:</td>
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
                    <select name="birthyear" id="birthyear" onchange="showbirthday();">
                        <option value="">年</option>
                        <?php for($i=$year;$i>=1960;$i--):?>
                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                        <?php endfor; ?>
                    </select>
                    <select name="birthmonth" id="birthmonth" onchange="showbirthday();">
                        <option value="">月</option>
                        <?php for($i=1;$i<=12;$i++): ?>
                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                        <?php endfor; ?>
                    </select>
                    <select name="birthday" id="birthday"></select>
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