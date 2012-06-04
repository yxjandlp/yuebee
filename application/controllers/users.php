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
    public function home($uid,$nickname = null){

        $uid = intval($uid);
        $nickname = urldecode($nickname);



        $this->load->model('user_feed_model','feed');

        if( $user_info = $this->user->get_info_uid($uid) ){//判断用户是否存在

            if( $user_info->nickname != $nickname ){//如果url中的昵称和真实昵称不相符，以uid为准进行重定向

                redirect(site_url('users/'.$uid.'/'.$user_info->nickname));

            }



            $tpl_name = "art";

            $data = array();
            $data['title'] = "yuebee | ".$nickname;
            $data['uid'] = $uid;
            $data['nickname'] = $nickname;
            $data['user_info'] = $user_info;
            $data['current_app'] = "news";
            $data['tpl_name'] = $tpl_name;
            $data['statuses'] = $this->feed->get_feed($uid,1);//获取我的状态
            $data['type'] = '';

            $current_uid = intval($this->input->cookie('uid'));//取得登录用户uid
            $data['is_current'] = ( $current_uid == $uid );//判断是否是当前登录用户
            $data['current_user_info'] = $this->user->get_info_uid($current_uid);//取得登录用户的信息

            $this->load->view('users/tpl/'.$tpl_name. '/mainpage/common/user_common_header',$data);
            $this->load->view('users/tpl/'.$tpl_name. '/mainpage/common/user_common_left',$data);
            $this->load->view('users/tpl/'.$tpl_name. '/mainpage/user_index_view',$data);
            $this->load->view('users/tpl/'.$tpl_name. '/mainpage/common/user_common_right',$data);
            $this->load->view('users/tpl/'.$tpl_name. '/mainpage/common/user_common_footer',$data);


        }else{

            show_404('');

        }


    }

    /*
     * 个人资料
     */
    public function profile($uid = null,$nickname = null ){


        $uid = intval($uid);
        $nickname = urldecode($nickname);

        if( $user_info = $this->user->get_info_uid($uid) ){//判断用户是否存在

            if( $user_info->nickname != $nickname ){//如果url中的昵称和真实昵称不相符，以uid为准进行重定向

                redirect(site_url('profile/'.$uid.'/'.$user_info->nickname));

            }

            $tpl_name = "art";

            $data = array();
            $data['title'] = "yuebee | 用户资料";
            $data['uid'] = $uid;
            $data['nickname'] = $nickname;
            $data['user_info'] = $user_info;
            $data['current_app'] = "profile";
            $data['tpl_name'] = $tpl_name;
            $data['type'] = '';

            $current_uid = intval($this->input->cookie('uid'));//取得用户uid
            $data['is_current'] = ( $current_uid == $uid );//判断是否是当前登录用户
            $data['current_user_info'] = $this->user->get_info_uid($current_uid);//取得登录用户的信息

            $this->load->view('users/tpl/'.$tpl_name. '/mainpage/common/user_common_header',$data);
            $this->load->view('users/tpl/'.$tpl_name. '/mainpage/common/user_common_left',$data);
            $this->load->view('users/tpl/'.$tpl_name. '/mainpage/user_profile_view',$data);
            $this->load->view('users/tpl/'.$tpl_name. '/mainpage/common/user_common_right',$data);
            $this->load->view('users/tpl/'.$tpl_name. '/mainpage/common/user_common_footer',$data);


        }else{

            show_404('');

        }

    }

    /*
     * 好友列表
     */
    public function friend($uid = null,$nickname = null ){


        $uid = intval($uid);
        $nickname = urldecode($nickname);

        if( $user_info = $this->user->get_info_uid($uid) ){//判断用户是否存在

            if( $user_info->nickname != $nickname ){//如果url中的昵称和真实昵称不相符，以uid为准进行重定向

                redirect(site_url('profile/'.$uid.'/'.$user_info->nickname));

            }

            $tpl_name = "art";

            $data = array();
            $data['title'] = "yuebee | 好友";
            $data['uid'] = $uid;
            $data['nickname'] = $nickname;
            $data['user_info'] = $user_info;
            $data['current_app'] = "friend";
            $data['tpl_name'] = $tpl_name;
            $data['type'] = '';

            $current_uid = intval($this->input->cookie('uid'));//取得用户uid
            $data['is_current'] = ( $current_uid == $uid );//判断是否是当前登录用户
            $data['current_user_info'] = $this->user->get_info_uid($current_uid);//取得登录用户的信息

            $this->load->model('User_friend_model','friend');
            $data['friends'] = $this->friend->get_friends($uid);

            $this->load->view('users/tpl/'.$tpl_name. '/mainpage/common/user_common_header',$data);
            $this->load->view('users/tpl/'.$tpl_name. '/mainpage/common/user_common_left',$data);
            $this->load->view('users/tpl/'.$tpl_name. '/mainpage/user_friend_view',$data);
            $this->load->view('users/tpl/'.$tpl_name. '/mainpage/common/user_common_right',$data);
            $this->load->view('users/tpl/'.$tpl_name. '/mainpage/common/user_common_footer',$data);


        }else{

            show_404('');

        }

    }

}

/* End of file users.php */
/* Location: ./application/controllers/users.php */