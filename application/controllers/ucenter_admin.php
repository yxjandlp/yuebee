<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 5/11/12
 * Time: 4:29 PM
 *
 * 个人中心管理
 *
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ucenter_admin extends CI_Controller {


    public function __construct(){

        parent::__construct();

        $this->load->model('User_model','user');
        $this->load->model('User_profile_model','profile');

        $this->load->model('User_notification_model','notification');

    }

    public function index(){

        $uid = intval($this->input->cookie('uid'));//取得用户uid

        $data = array();
        $data['title'] = "yuebee | 个人资料";
        $data['current_app'] = "admin";//好友请求

        $data['profile_info'] = $this->profile->get_profile_id($uid);
        $data['user_info'] = $this->user->get_info_uid($uid);
        $data['request_num'] = $this->notification->get_num_by_type($uid,0,2);//获得好友请求的条数

        $data['notification_num'] = $this->notification->get_notification_num($uid,0);//取得所有消息数

        $this->load->view('users/admin/common/left',$data);
        $this->load->view('users/admin/ucenter_admin_view',$data);
        $this->load->view('users/admin/common/center',$data);
        $this->load->view('common/footer',$data);

    }


    /*
     * 修改个人资料
     */
    public function profile($type=null){

        $uid = intval($this->input->cookie('uid'));//取得用户uid

        $data = array();

        if($type == "edu"){

            $data['type'] = "edu";//教育信息

        }else{

            $data['type'] = "basic";//基本信息

        }

        $data['title'] = "yuebee | 个人资料";
        $data['current_app'] = "admin";//好友请求
        $data['current_action'] = "profile";//个人资料

        $data['profile_info'] = $this->profile->get_profile_id($uid);
        $data['user_info'] = $this->user->get_info_uid($uid);
        $data['request_num'] = $this->notification->get_num_by_type($uid,0,2);//获得好友请求的条数

        $data['notification_num'] = $this->notification->get_notification_num($uid,0);//取得所有消息数

        $this->load->view('users/admin/common/left',$data);

        if($type == "edu"){

            $data['type'] = "edu";//教育信息
            $this->load->view('users/admin/admin_profile_edu_view',$data);

        }else{

            $data['year'] = intval(date('Y')) - 5;
            $data['type'] = "basic";//基本信息

            $this->load->model('Common_district_model','district');
            $data['provinces'] = $this->district->get_province();

            $this->load->view('users/admin/admin_profile_view',$data);

        }

        $this->load->view('users/admin/common/center',$data);
        $this->load->view('common/footer',$data);


    }

    /*
     * 修改头像
     */
    public function avatar(){

        $this->load->helper('form');//载入表单类

        $uid = intval($this->input->cookie('uid'));//取得用户uid

        $data = array();
        $data['title'] = "yuebee | 编辑头像";
        $data['current_app'] = "admin";//好友请求
        $data['current_action'] = "avatar";//编辑头像

        $data['profile_info'] = $this->profile->get_profile_id($uid);
        $data['user_info'] = $this->user->get_info_uid($uid);
        $data['request_num'] = $this->notification->get_num_by_type($uid,0,2);//获得好友请求的条数

        $data['notification_num'] = $this->notification->get_notification_num($uid,0);//取得所有消息数

        $this->load->view('users/admin/common/left',$data);
        $this->load->view('users/admin/admin_avatar_view',$data);
        $this->load->view('users/admin/common/center',$data);
        $this->load->view('common/footer',$data);

    }

    /*
     * 处理上传头像
     */
    public function upload_avatar(){


        $uid = intval($this->input->cookie('uid'));//取得用户uid
        $nickname = $this->user->get_nickname($uid);
        $file_name = md5($nickname)."_".$uid.'.jpg';

        $config['upload_path'] =  dirname(__FILE__)."/../../static/uploads/";//上传目录
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '2048';
        $config['file_name'] = $file_name;
        $config['overwrite'] = TRUE;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('avatar_file') ){

            $error = array('error' => $this->upload->display_errors());
            //$error = array('error' => $config['upload_path']);
            echo json_encode($error);

        }else{

            $file_data = $this->upload->data();


            $max_width = "500";
            $max_height = "600";

            $resize_width = $real_width = $file_data['image_width'];
            $resize_height = $real_height = $file_data['image_height'];

            if( $real_width > $max_width || $real_height > $max_height ){

                if( ( $max_width / $real_width ) > ( $max_height / $real_height )){//计算缩放比例

                    $scale = $max_height / $real_height;

                }else{

                    $scale = $max_width / $real_width;

                }

                $resize_width = floor($real_width*$scale);
                $resize_height = floor($real_height*$scale);

                $img_config['image_library'] = 'gd2';
                $img_config['source_image'] = $config['upload_path'].$file_data['file_name'];
                $img_config['maintain_ratio'] = TRUE;
                $img_config['width'] = $resize_width;
                $img_config['height'] = $resize_height;

                $this->load->library('image_lib', $img_config);

                $this->image_lib->resize();
            }

            $data = array(

                'file_name' => $file_data['file_name'],
                'image_width' => $resize_width,
                'image_height' => $resize_height

            );

            echo json_encode($data);

        }

    }

    /*
     * 保存头像截图
     *
     * 三种尺寸 150x150 50x50 30x30
     *
     */
    public function save_avatar(){


        //---------------取得头像区域--------------------------------
        $left = intval($this->input->post('left'));//左上角顶点的X座标
        $top = intval($this->input->post('top'));//左上角顶点的Y座标
        $width = intval($this->input->post('width'));//宽
        $height = intval($this->input->post('height'));//高

        $static_dir = dirname(__FILE__)."/../../static";

        $uid = intval($this->input->cookie('uid'));//取得用户uid
        $nickname = $this->user->get_nickname($uid);
        $file_name = md5($nickname)."_".$uid.'.jpg';

        $img_config['image_library'] = 'gd2';
        $img_config['source_image'] = $static_dir . "/uploads/".$file_name;
        $img_config['maintain_ratio'] = FALSE;//不按原来的比例
        $img_config['x_axis'] = $left;
        $img_config['y_axis'] = $top;
        $img_config['width'] = $width;
        $img_config['height'] = $height;

        $this->load->library('image_lib', $img_config);

        $this->image_lib->crop();//裁剪头像

        $this->image_lib->clear();//清除之前的值

        $config['image_library'] = 'gd2';
        $config['source_image'] =  $static_dir . "/uploads/".$file_name;
        $config['maintain_ratio'] = FALSE;//不按原来的比例

        $md5_name = md5($nickname);


        $config['width'] = 150;//尺寸150
        $config['height'] = 150;
        $config['new_image'] = $static_dir . '/img/avatar/'.$md5_name."_".$uid."_150x150".'.jpg';

        $this->image_lib->initialize($config);

        $this->image_lib->resize();

        $config['width'] = 50;//尺寸50
        $config['height'] = 50;
        $config['new_image'] = $static_dir . '/img/avatar/'.$md5_name."_".$uid."_50x50".'.jpg';

        $this->image_lib->initialize($config);

        $this->image_lib->resize();

        $config['width'] = 30;//尺寸30
        $config['height'] = 30;
        $config['new_image'] = $static_dir . '/img/avatar/'.$md5_name."_".$uid."_30x30".'.jpg';

        $this->image_lib->initialize($config);

        $this->image_lib->resize();

        $this->user->set_avatar_modified($uid);//将用户头像状态设为已自定义


    }


    /*
     * 级联获取地区信息
     */
    public function get_city(){

        $province_id = intval($this->input->post('id'));

        $this->load->model("Common_district_model",'district');
        $cities = $this->district->get_city($province_id);

        $city_json = array();

        foreach( $cities as $city ){

            $city_json[] = array(

                "id"   => $city->id,
                "name" => $city->name

            );

        }

        echo json_encode($city_json);

    }

}

/* End of file ucenter_admin.php */
/* Location: ./application/controllers/ucenter_admin.php */