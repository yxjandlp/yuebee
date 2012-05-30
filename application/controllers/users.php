<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 5/2/12
 * Time: 11:40 PM
 *
 * 用户空间的操作
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct(){

        parent::__construct();

        $this->load->model('User_profile_model','profile');
        $this->load->model('User_model','user');

    }


    public function index(){

        show_404('users/');

    }


    /*
     * 用户的个人主页
     */
    public function home($uid,$nickname){

        $uid = intval($uid);
        $nickname = urldecode($nickname);

        if( $user_info = $this->user->get_info_uid($uid) ){//判断用户是否存在

            $tpl_name = "default";

            $data = array();
            $data['title'] = "yuebee | ".$nickname."的空间";
            $data['uid'] = $uid;
            $data['nickname'] = $nickname;
            $data['user_info'] = $user_info;


            $this->load->view('users/tpl/home/'.$tpl_name. '/user_home_view',$data);


        }else{

            show_404('');

        }


    }

}

/* End of file users.php */
/* Location: ./application/controllers/users.php */