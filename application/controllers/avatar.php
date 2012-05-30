<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 5/13/12
 * Time: 5:11 PM
 *
 * 获取头像文件
 *
 */

class Avatar extends CI_Controller {

    public function __construct(){

        parent::__construct();

    }

    /**
     * @param $uid
     * @param $nickname
     * @param $size
     * @return string
     */
    public function get($uid,$nickname,$size,$random){

        $uid = intval($uid);
        $size = intval($size);

        $this->load->model('User_model','user');
        $avatar_status = $this->user->get_avatar_status($uid);//获得头像状态

        $dir = site_url('static/img/avatar');

        if( $avatar_status == 0 ){//返回默认头像

            $avatar_file = "default_".$size."x".$size.".jpg";

        }else {//返回自定义头像

            $avatar_file = $nickname."_".$uid."_".$size."x".$size.".jpg";
        }

        header('Location:'.$dir.'/'.$avatar_file.'?r='.$random);

    }


}