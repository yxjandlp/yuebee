<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 5/3/12
 * Time: 5:19 PM
 *
 * 个人中心
 *
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ucenter extends CI_Controller {

    public function __construct(){

        parent::__construct();

        $this->load->model('User_model','user');
        $this->load->model('User_profile_model','profile');
 //       $this->load->model('Friend_request_model','request');
        $this->load->model('User_notification_model','notification');
        $this->load->model('User_feed_model','feed');

    }

    /*
     * 用户个人中心主页
     */
    public function index(){


        $uid = intval($this->input->cookie('uid'));//取得用户uid
        $user_info = $this->user->get_info_uid($uid);//取得用户信息

        $data = array();
        $data['title'] = "yuebee | 个人中心";
        $data['current_app'] = "news";//新鲜事

        $data['user_info'] = $user_info;
        $data['profile_info'] = $this->profile->get_profile_id($uid);
        $data['request_num'] = $this->notification->get_num_by_type($uid,0,2);//获取总的好友请求数

        $data['notification_num'] = $this->notification->get_notification_num($uid,0);//取得所有消息数

        $feeds_result = $this->feed->get_friend_feed_limit($uid,0,10);

        $feeds = array();

        $this->load->model('User_comment_model','comment');
        foreach( $feeds_result as $feed ){

            $first_comment = "";
            $last_comment = "";

            $reply_num = intval($feed->reply_num);

            if( $reply_num >= 1 ){

                $first_comment = $this->comment->get_side_comment($feed->fid,0);//第一条评论

            }

            if( $reply_num >= 2 ){

                $last_comment = $this->comment->get_side_comment($feed->fid,1);//最后一条评论

            }


            $feeds[] = array(

                'feed_id'        => $feed->fid,
                'uid'            => $feed->uid,
                'feed_type'      => $feed->feed_type,
                'nickname'       => $feed->nickname,
                'message'        => $feed->message,
                'reply_num'      => $feed->reply_num,
                'first_comment'  => $first_comment,
                'last_comment'   => $last_comment,
                'create_time'    => $feed->create_time

            );

        }

        $data['feeds'] = $feeds;

        $this->load->view('users/common/left',$data);

        $this->load->view('users/user_ucenter_view',$data);//新鲜事界面

        $this->load->view('users/common/right',$data);
        $this->load->view('common/footer',$data);



    }


    /*
    *
    * 状态书写规则
    * 字数为1-240字
    *
    */
    public function status_check($status){

        $length = mb_strlen($status);

        if( $length >= 1 && $length <= 240){

            return true;

        }else{

            $this->form_validation->set_message('status_check', '字数在 1－240 之间');
            return false;

        }

    }

    /*
     * 发布状态
     */
    public function publish_status(){


        $uid = intval($this->input->cookie('uid'));
        $content = $this->input->post('content');
        $user_info = $this->user->get_info_uid($uid);//取得用户信息

        $type = 1;//设置新鲜事类型为状态

        $this->feed->add_feed($uid,$user_info->nickname,$content,$type);

    }



    /*
     * 异步传输消息条数
     */
    public function count_notification(){

        $to_uid = intval($this->input->cookie('uid'));
        $checked = 0;//未读消息

        $num_of_notification = $this->notification->get_notification_num($to_uid,$checked);

        echo $num_of_notification;//传送消息数

    }

    /*
     * 显示消息
     */
    public function notification($type){


        $uid = intval($this->input->cookie('uid'));//取得用户uid
        $notification_type = array('system','friend','comment');
        $checked = 0;//未读消息

        if( ! in_array($type,$notification_type) ){//过滤type的值

            $type = 'system';

        }

        $data = array();
        $data['title'] = "yuebee | 消息";
        $data['current_app'] = "notification";

        $data['profile_info'] = $this->profile->get_profile_id($uid);//详细资料
        $data['user_info'] = $this->user->get_info_uid($uid);//用户信息

        $data['system_num'] = $this->notification->get_num_by_type($uid,0,1);//系统消息条数
        $data['request_num'] = $this->notification->get_num_by_type($uid,0,2);//好友请求条数
        $data['comment_num'] = $this->notification->get_num_by_type($uid,0,3);//状态评论消息条数

        $data['notification_num'] = $this->notification->get_notification_num($uid,0);//取得所有消息数

        $type_id = intval(array_search($type,$notification_type)) + 1;//取得键值
        $data['notifications'] = $this->notification->get_notifications($uid,$type_id,$checked);//所有未读消息
        $data['type'] = $type;//消息类型

        $this->notification->set_checked_type($uid,$type_id);//设置该类型的消息为已读

        $this->load->view('users/common/left',$data);

        $this->load->view('users/user_notification_view',$data);

        $this->load->view('users/common/right',$data);
        $this->load->view('common/footer',$data);;

    }

    /*
     * 我的状态模块
     */
    public function status($type = null,$feed_id = null){


        $uid = intval($this->input->cookie('uid'));//取得用户uid
        $user_info = $this->user->get_info_uid($uid);//取得用户信息

        $data = array();
        $data['title'] = "yuebee | 状态";
        $data['current_app'] = "status";//新鲜事

        $data['user_info'] = $user_info;
        $data['profile_info'] = $this->profile->get_profile_id($uid);

        $data['request_num'] = $this->notification->get_num_by_type($uid,0,2);//获取总的好友请求数

        $data['notification_num'] = $this->notification->get_notification_num($uid,0);//取得所有消息数

        if( $type == 'reply' ){

            $feed_id = intval($feed_id);
            $data['statuses'] = $this->feed->get_feeds_fid($feed_id);
            $data['type'] = $type;

            $this->load->model('User_comment_model','comment');
            $data['comments'] = $this->comment->get_comments($feed_id);



        }else{

            $data['statuses'] = $this->feed->get_feed($uid,1);//获取我的状态
            $data['type'] = '';

        }



        $this->load->view('users/common/left',$data);
        $this->load->view('users/user_status_view',$data);
        $this->load->view('users/common/right',$data);
        $this->load->view('common/footer',$data);;


    }

    /*
     * 同意添加好友请求
     */
    public function accept_friend_request(){

        $notification_id = intval($this->input->post('id'));//消息的id
        $notification_info = $this->notification->get_notification_id($notification_id);//消息的所有信息

        $uid = intval($this->input->cookie('uid'));
        $friend_info = $this->user->get_info_uid($notification_info->from_uid);
        $user_info = $this->user->get_info_uid($uid);

        $this->load->model('User_friend_model','friend');
        $this->friend->add_friend($uid,$friend_info->uid,$friend_info->nickname);
        $this->friend->add_friend($friend_info->uid,$uid,$user_info->nickname);//互相添加对方为好友

        $this->notification->set_checked($notification_id);//设为已处理

        //添加feed,type为friend
        $message = "和<a href=''>".$friend_info->nickname."</a>成为了好友";
        $note = "<a href=''>".$user_info->nickname."</a>已接受您的好友请求";

        $this->feed->add_feed($uid,$user_info->nickname,$message,2);//添加到新鲜事中
        $this->notification->add_notification($notification_info->from_uid,$uid,$user_info->nickname,1,$note);//向请求方已接受请求提醒


    }

    /*
     * 显示好友
     */
    public function friend(){

        $uid = intval($this->input->cookie('uid'));//取得用户uid

        $data = array();
        $data['title'] = "yuebee | 好友";
        $data['current_app'] = "friend";//好友请求

        $data['profile_info'] = $this->profile->get_profile_id($uid);
        $data['user_info'] = $this->user->get_info_uid($uid);
        $data['request_num'] = $this->notification->get_num_by_type($uid,0,2);//获得好友请求的条数

        $data['notification_num'] = $this->notification->get_notification_num($uid,0);//取得所有消息数

        $this->load->model('User_friend_model','friend');
        $data['friends'] = $this->friend->get_friends($uid);

        //        $this->load->view('common/header',$data);
        $this->load->view('users/common/left',$data);
        $this->load->view('users/user_friend_view',$data);
        $this->load->view('users/common/right',$data);
        $this->load->view('common/footer',$data);

    }


    /*
     * 异步处理评论
     */
    public function comment(){

        $comment = $this->input->post('comment');

        if( $comment != ""){

            $feed_id = intval($this->input->post('fid'));//状态id值

            $uid = intval($this->input->cookie('uid'));//取得用户uid
            $user_info = $this->user->get_info_uid($uid);

            $this->load->model('User_comment_model','comment');

            $this->comment->add_comment($feed_id,$uid,$user_info->nickname,$comment);//添加评论

            //添加消息提醒
            if( $feed_info = $this->feed->get_feed_by_fid($feed_id) ){//获取状态的信息

                $to_uid = $feed_info->uid;

                //$to_uid =  $this->feed->get_author_id($feed_id);//根据feed_id
                $from_uid = $uid;
                $from_nickname = $user_info->nickname;
                $type = 3;//留言回复信息
                // $note ="haha";
                $note = "您的状态:<a href='".site_url('ucenter/status/reply/'.$feed_id)."'>".mb_substr($feed_info->message,0,4).(mb_strlen($feed_info->message) > 4?"。。。":"")."</a>有了新评论";

                $from_id = $feed_id;

                $this->notification->add_notification($to_uid,$from_uid,$from_nickname,$type,$note,$from_id);

            }

            $total_reply = $this->comment->get_reply_num($feed_id);//获得当前状态的回复数
            $this->feed->update_reply_num($feed_id,$total_reply);//更新状态的回复数

            $user = array(//返回评论者的数据

                'feed_id'     => $feed_id,
                'uid'         => $user_info->uid,
                'author_nickname'    => $user_info->nickname,
                'md5_nickname'       => md5($user_info->nickname)

            );

            echo json_encode($user);



        }

    }


    /*
     * 返回指定状态的所有回复
     */
    public function all_comment(){

        $feed_id = intval($this->input->post('fid'));

        $this->load->model('User_comment_model','comment');

        $comments = $this->comment->get_comments($feed_id);

        $comments_json = array();

        foreach( $comments as $comment ){//取得回复内容，格式为json

            $comments_json[] = array(

                'feed_id'          => $feed_id,
                'author_id'        => $comment->author_id,
                'author_nickname'  => $comment->author_nickname,
                'comment'          => $comment->comment,
                'create_time'      => date('Y-m-d H:i',$comment->create_time),
                'md5_nickname'     => md5($comment->author_nickname)

            );

        }

        echo json_encode($comments_json);//以json形式返回回复内容


    }

    /*
     * 点击获取更多新鲜事
     */
    public function more_feed(){


        $uid = intval($this->input->cookie('uid'));//取得用户uid
        $offset = intval($this->input->post('offset'));

        $more_feeds = $this->feed->get_friend_feed_limit($uid,$offset,5);

        $feeds = array();

        $this->load->model('User_comment_model','comment');
        foreach( $more_feeds as $feed ){

            $first_comment = "";
            $last_comment = "";

            $reply_num = intval($feed->reply_num);

            if( $reply_num >= 1 ){

                $first_comment = $this->comment->get_side_comment($feed->fid,0);//第一条评论
                $first_comment->md5_nickname = md5($first_comment->author_nickname);

            }

            if( $reply_num >= 2 ){

                $last_comment = $this->comment->get_side_comment($feed->fid,1);//最后一条评论
                $last_comment->md5_nickname = md5($last_comment->author_nickname);

            }


            $feeds[] = array(

                'feed_id'        => $feed->fid,
                'uid'            => $feed->uid,
                'feed_type'      => $feed->feed_type,
                'nickname'       => $feed->nickname,
                "md5_nickname"   => md5($feed->nickname),
                'message'        => $feed->message,
                'reply_num'      => $feed->reply_num,
                'first_comment'  => $first_comment,
                'last_comment'   => $last_comment,
                'create_time'    => $feed->create_time

            );

        }

        echo json_encode($feeds);


    }

    /*
    * 返回剩余回复
    */
    public function more_comment(){


        $feed_id = intval($this->input->post('fid'));
        $comments_json = array();

        if( $num = $this->feed->get_reply_num($feed_id) ){

            $this->load->model('User_comment_model','comment');
            $comments = $this->comment->get_comment_limit($feed_id,1,$num - 2);//获取剩余的回复内容


            foreach( $comments as $comment ){//取得回复内容，格式为json

                $comments_json[] = array(

                    'feed_id'          => $feed_id,
                    'author_id'        => $comment->author_id,
                    'author_nickname'  => $comment->author_nickname,
                    'md5_nickname'     => md5($comment->author_nickname),
                    'comment'          => $comment->comment,
                    'create_time'      => date('Y-m-d H:i',$comment->create_time)

                );

            }


        }

        echo json_encode($comments_json);//以json形式返回回复内容

    }


}

/* End of file ucenter.php */
/* Location: ./application/controllers/ucenter.php */