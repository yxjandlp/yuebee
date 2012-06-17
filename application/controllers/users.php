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
        $this->load->model('User_follow_model','follow');

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

            $data['fans_num'] = $this->follow->get_fans_num($uid);//粉丝数量
            $data['follow_num'] = $this->follow->get_follow_num($uid);//关注数量

            if( ! $data['is_current'] ){//如果不是当前登录用户

                $data['follow_status'] = $this->follow->get_follow_status($current_uid,$uid);

            }

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

            $data['fans_num'] = $this->follow->get_fans_num($uid);//粉丝数量
            $data['follow_num'] = $this->follow->get_follow_num($uid);//关注数量

            if( ! $data['is_current'] ){//如果不是当前登录用户

                $data['follow_status'] = $this->follow->get_follow_status($current_uid,$uid);

            }

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
     * 粉丝列表
     */
    public function fans($uid = null,$nickname = null ){


        $uid = intval($uid);
        $nickname = urldecode($nickname);

        if( $user_info = $this->user->get_info_uid($uid) ){//判断用户是否存在

            if( $user_info->nickname != $nickname ){//如果url中的昵称和真实昵称不相符，以uid为准进行重定向

                redirect(site_url('fans/'.$uid.'/'.$user_info->nickname));

            }

            $tpl_name = "art";

            $data = array();
            $data['title'] = "yuebee | 粉丝";
            $data['uid'] = $uid;
            $data['nickname'] = $nickname;
            $data['user_info'] = $user_info;
            $data['current_app'] = "fans";
            $data['tpl_name'] = $tpl_name;
            $data['type'] = '';

            $current_uid = intval($this->input->cookie('uid'));//取得用户uid
            $data['is_current'] = ( $current_uid == $uid );//判断是否是当前登录用户
            $data['current_user_info'] = $this->user->get_info_uid($current_uid);//取得登录用户的信息

            $data['fans_num'] = $this->follow->get_fans_num($uid);//粉丝数量
            $data['follow_num'] = $this->follow->get_follow_num($uid);//关注数量

            if( ! $data['is_current'] ){//如果不是当前登录用户

                $data['follow_status'] = $this->follow->get_follow_status($current_uid,$uid);

            }

            $data['fanses'] = $this->follow->get_fans($uid);

            $this->load->view('users/tpl/'.$tpl_name. '/mainpage/common/user_common_header',$data);
            $this->load->view('users/tpl/'.$tpl_name. '/mainpage/common/user_common_left',$data);
            $this->load->view('users/tpl/'.$tpl_name. '/mainpage/user_fans_view',$data);
            $this->load->view('users/tpl/'.$tpl_name. '/mainpage/common/user_common_right',$data);
            $this->load->view('users/tpl/'.$tpl_name. '/mainpage/common/user_common_footer',$data);


        }else{

            show_404('');

        }

    }

    /*
    * 关注列表
    */
    public function follow($uid = null,$nickname = null ){


        $uid = intval($uid);
        $nickname = urldecode($nickname);

        if( $user_info = $this->user->get_info_uid($uid) ){//判断用户是否存在

            if( $user_info->nickname != $nickname ){//如果url中的昵称和真实昵称不相符，以uid为准进行重定向

                redirect(site_url('follow/'.$uid.'/'.$user_info->nickname));

            }

            $tpl_name = "art";

            $data = array();
            $data['title'] = "yuebee | 关注";
            $data['uid'] = $uid;
            $data['nickname'] = $nickname;
            $data['user_info'] = $user_info;
            $data['current_app'] = "follow";
            $data['tpl_name'] = $tpl_name;
            $data['type'] = '';

            $current_uid = intval($this->input->cookie('uid'));//取得用户uid
            $data['is_current'] = ( $current_uid == $uid );//判断是否是当前登录用户
            $data['current_user_info'] = $this->user->get_info_uid($current_uid);//取得登录用户的信息

            $data['fans_num'] = $this->follow->get_fans_num($uid);//粉丝数量
            $data['follow_num'] = $this->follow->get_follow_num($uid);//关注数量

            if( ! $data['is_current'] ){//如果不是当前登录用户

                $data['follow_status'] = $this->follow->get_follow_status($current_uid,$uid);

            }

            $data['followes'] = $this->follow->get_follow($uid);

            $this->load->view('users/tpl/'.$tpl_name. '/mainpage/common/user_common_header',$data);
            $this->load->view('users/tpl/'.$tpl_name. '/mainpage/common/user_common_left',$data);
            $this->load->view('users/tpl/'.$tpl_name. '/mainpage/user_follow_view',$data);
            $this->load->view('users/tpl/'.$tpl_name. '/mainpage/common/user_common_right',$data);
            $this->load->view('users/tpl/'.$tpl_name. '/mainpage/common/user_common_footer',$data);


        }else{

            show_404('');

        }

    }

    /*
     * 加关注
     */
    public function add_follow(){

        $follow_uid = intval($this->input->post('follow_uid'));//接受方id
        $uid = intval($this->input->cookie('uid'));//请求方id

        $follow_user_info = $this->user->get_info_uid($follow_uid);
        $user_info = $this->user->get_info_uid($uid);
        $from_nickname = $user_info->nickname;

        $note = "<a href='".site_url('users/'.$uid."/".$from_nickname)."'>{$from_nickname}</a> 关注了您";//设置提醒内容
        $type = 2;//设置醒类型为关注
        $this->load->model('User_notification_model','notification');
        $this->notification->add_notification($follow_uid,$uid,$from_nickname,$type,$note);//添加提醒消息

        $follow_status = $this->follow->add_follow($uid,$follow_uid,$from_nickname,$follow_user_info->nickname);

        echo $follow_status;

    }

    /*
     * 取消关注
     */
    public function cancel_follow(){

        $follow_uid = intval($this->input->post('follow_uid'));//接受方id
        $uid = intval($this->input->cookie('uid'));//请求方id

        $this->follow->cancel_follow($uid,$follow_uid);

    }

}

/* End of file users.php */
/* Location: ./application/controllers/users.php */