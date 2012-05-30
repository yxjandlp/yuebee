<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 5/11/12
 * Time: 4:47 PM
 *
 * 编辑头像界面
 *
 *
 */
?>
<div class="admin_menu_top">
    <a href="<?php echo site_url('ucenter/');?>">个人中心</a> »
    <a href="<?php echo site_url('ucenter/admin');?>">管理</a> »
    <a href="<?php echo site_url('ucenter/admin/avatar')?>">编辑头像</a>
</div>
<div class="avatar_top">
    <h2>更换头像</h2>
</div>
<div class="upload">
    <form action="<?php echo site_url('ucenter_admin/upload_avatar');?>" method="post" enctype="multipart/form-data" id="upload_avatar_form">
        <table style="margin-bottom: 10px;">
            <tbody>
            <tr>
                <th>头像图片：</th>
                <td>
                    <input id="avatar_file" type="file" size="30" name="avatar_file" />
                    <input id="upload_avatar_btn" type="submit" value="上传" />
                </td>
                <td>
                    <span></span><a href="<?php echo site_url('ucenter/admin/avatar');?>" style="display: none;text-decoration: underline;" id="re_choose">重新选择</a></span>
                </td>
            </tr>
            </tbody>
        </table>
        <div id="new_avatar" style="float:left;margin-right: 10px;width: 500px;"><img id="avatar_tmp" src="" style=''/></div>
        <div class="small_preview" style="float:left;">
            <div style="width:150px;height:150px;overflow:hidden;" class="preview_container">
                <img id="preview_1" class="jcrop_preview" alt="Preview" src="" style="display:none;">
            </div>
            <div style="width:50px;height:50px;overflow:hidden;" class="preview_container">
                <img id="preview_2" class="jcrop_preview" alt="Preview" src="" style="display:none;">
            </div>
            <div style="width:30px;height:30px;overflow:hidden;" class="preview_container">
                <img id="preview_3" class="jcrop_preview" alt="Preview" src="" style="display:none;">
            </div>
        </div>
        <div class="clear"></div>
        <div id='btn_saves' style='display:none;'>
            <input type='button' value='保存' id='btn_save_region' />
            <input type='button' value='取消' id='btn_save_cancel' />
        </div>
    </form>
    <div class="error_msg" id="upload_error" style="text-align: center;display: none;">请选择jpg、gif格式，且文件大小不超过2M的图片</div>
</div>
<form id='form_save' action="/action/user/save_portrait" style='display:none;'>
    <input type='hidden' id='img_left' name='left' value='10'/>
    <input type='hidden' id='img_top' name='top' value='10'/>
    <input type='hidden' id='img_width' name='width' value='200'/>
    <input type='hidden' id='img_height' name='height' value='200'/>
</form>


