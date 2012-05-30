<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 5/4/12
 * Time: 3:07 PM
 *
 *
 * 对好友的一些操作
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Friend extends CI_Controller {

    public function __construct(){

        parent::__construct();

        $this->load->model('User_model','user');
//        $this->load->model('Friend_request_model','request');
        $this->load->model('User_notification_model','notification');


    }

    public function index(){

        //pass

    }


    /*
     * 处理好友请求
     */
    public function add_request(){

        $to_uid = intval($this->input->post('to'));//接受方id
        $from_uid = intval($this->input->cookie('uid'));//请求方id

        $from_user_info = $this->user->get_info_uid($from_uid);
        $from_nickname = $from_user_info->nickname;

 //       $this->request->add_request($to_uid,$from_uid,$from_nickname);//添加请求

        $note = "<a href='".site_url('users/'.$from_nickname)."'>{$from_nickname}</a> 请求添加您为好友";//设置提醒内容
        $type = 2;//设置醒类型为好友请求
        $this->load->model('User_notification_model','notification');
        $this->notification->add_notification($to_uid,$from_uid,$from_nickname,$type,$note);//添加提醒消息

    }



}

/* End of file friend.php */
/* Location: ./application/controllers/friend.php */


