<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 5/14/12
 * Time: 1:12 AM
 *
 * 编辑教育信息
 *
 *
 */
?>
<div class="admin_menu_top">
    <a href="<?php echo site_url('ucenter/');?>">个人中心</a> »
    <a href="<?php echo site_url('ucenter/admin');?>">管理</a> »
    <a href="<?php echo site_url('ucenter/admin/profile')?>">个人资料</a> »
    <a href="<?php echo site_url('ucenter/admin/profile/edu');?>">教育信息</a>

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

</div>