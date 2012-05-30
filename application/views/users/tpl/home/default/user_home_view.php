<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 5/16/12
 * Time: 1:32 AM
 *
 * 默认空间模板
 *
 *
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $title;?></title>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('static/css/tpl/home/default/default.css');?>">
</head>
<body>
<div id="default_main">
    <div id="default_top">
        <h1><?php echo $nickname;?>的个人空间</h1>
        <hr />
    </div>
    <img src="<?php echo site_url('avatar/get/'.$uid.'/'.md5($nickname).'/150/'.rand());?>" height="150" width="150" /><br />
</div>
</body>
</html>