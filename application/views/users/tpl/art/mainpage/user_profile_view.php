<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 6/4/12
 * Time: 12:28 AM
 *
 * 用户资料界面
 *
 */
?>
    <div id="user_profile_block">
        <div class="user_profile_item">
            <div class="user_profile_title">
                <span>基本信息</span>
                <a href="<?php echo site_url('accounts/settings/index');?>">修改</a>
            </div>
            <table border="0" class="basic_profile_tb">
                <tr>
                    <td style="text-align: right;">昵称:</td>
                    <td><?php echo $user_info->nickname;?></td>
                </tr>
                <tr>
                    <td style="text-align: right;">真实姓名:</td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align: right;">性别:</td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align: right;">生日:</td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align: right;">家乡:</td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align: right;">现居地:</td>
                    <td></td>
                </tr>
                <tr>
                    <td style="vertical-align: top;">自我描述:</td>
                    <td></td>
                </tr>
            </table>
        </div>
        <div class="user_profile_item">
            <div class="user_profile_title">
                <span>教育信息</span>
                <a href="<?php echo site_url('accounts/settings/edu');?>">修改</a>
            </div>
            暂未填写教育经历
        </div>
    </div>
</div>