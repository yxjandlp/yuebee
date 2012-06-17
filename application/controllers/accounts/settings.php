<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 6/4/12
 * Time: 11:51 AM
 *
 * 帐号设置
 *
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller{


    public function __construct(){

        parent::__construct();

        $this->load->model('User_model','user');

    }

    /*
     * 个人基本资料设置
     */
    public function index(){

        $uid = intval($this->input->cookie('uid'));//取得用户uid
        $user_info = $this->user->get_info_uid($uid);//取得用户信息

        $tpl_name = "art";

        $data = array();
        $data['title'] = "yuebee | 基本资料设置";
        $data['current_app'] = "index";//基本资料
        $data['current_block'] = "profile";//个人资料
        $data['tpl_name'] = "art";//模板名

        $data['user_info'] = $user_info;

        $this->load->model('Common_district_model','district');
        $data['provinces'] = $this->district->get_province();//获取地区信息

        $data['year'] = intval(date('Y')) - 5;

        $config = array(
            array(
                'field'   => 'profile_nickname',
                'label'   => '昵称',
                'rules'   => 'callback_profile_nickname_check'
            )
        );

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules($config);

        if ( $this->form_validation->run() == false ){

            $this->load->view('users/tpl/'.$tpl_name.'/settings/common/settings_common_header',$data);
            $this->load->view('users/tpl/'.$tpl_name.'/settings/common/settings_common_left',$data);
            $this->load->view('users/tpl/'.$tpl_name.'/settings/settings_index_view',$data);
            $this->load->view('users/tpl/'.$tpl_name.'/settings/common/settings_common_footer',$data);


        }else{

            $profile = array(

                "uid" => $uid,
                "birth_year" => $this->input->post('birth_year'),
                "bitth_month" => $this->input->post('birth_month'),
                "birth_day" => $this->input->post('birth_day'),
                "gender" => $this->input->post('gender'),
                "real_name" => $this->input->post('real_name'),
                "hometown_1" => $this->input->post('hometown_1'),
                "hometown_2" => $this->input->post('hometown_2'),
                "settle_1" => $this->input->post('settle_2'),
                "self_desc" => $this->input->post('self_desc')

            );

            $this->load->model('User_profile_model','profile');
            $this->profile->update_profile($profile);//更新个人基本信息

            $this->load->view('users/tpl/'.$tpl_name.'/settings/common/settings_common_header',$data);
            $this->load->view('users/tpl/'.$tpl_name.'/settings/common/settings_common_left',$data);
            $this->load->view('users/tpl/'.$tpl_name.'/settings/settings_password_success_view',$data);
            $this->load->view('users/tpl/'.$tpl_name.'/settings/common/settings_common_footer',$data);


        }

    }

    /*
    * 教育信息设置
    */
    public function edu(){

        $uid = intval($this->input->cookie('uid'));//取得用户uid
        $user_info = $this->user->get_info_uid($uid);//取得用户信息

        $tpl_name = "art";

        $data = array();
        $data['title'] = "yuebee | 教育信息设置";
        $data['current_app'] = "edu";//教育信息
        $data['current_block'] = "profile";//个人资料
        $data['tpl_name'] = "art";//模板名

        $data['user_info'] = $user_info;

        $this->load->view('users/tpl/'.$tpl_name.'/settings/common/settings_common_header',$data);
        $this->load->view('users/tpl/'.$tpl_name.'/settings/common/settings_common_left',$data);
        $this->load->view('users/tpl/'.$tpl_name.'/settings/settings_edu_view',$data);
        $this->load->view('users/tpl/'.$tpl_name.'/settings/common/settings_common_footer',$data);

    }


    /*
     * 头像设置
     */
    public function avatar(){

        $this->load->helper('form');//载入表单类

        $uid = intval($this->input->cookie('uid'));//取得用户uid
        $user_info = $this->user->get_info_uid($uid);//取得用户信息

        $tpl_name = "art";

        $data = array();
        $data['title'] = "yuebee | 个人中心";
        $data['current_block'] = "avatar";//修改头像
        $data['tpl_name'] = "art";//模板名

        $data['user_info'] = $user_info;
        $this->load->view('users/tpl/'.$tpl_name.'/settings/common/settings_common_header',$data);
        $this->load->view('users/tpl/'.$tpl_name.'/settings/common/settings_common_left',$data);
        $this->load->view('users/tpl/'.$tpl_name.'/settings/settings_avatar_view',$data);
        $this->load->view('users/tpl/'.$tpl_name.'/settings/common/settings_common_footer',$data);

    }

    /*
     * 处理上传头像
     */
    public function upload_avatar(){


        $uid = intval($this->input->cookie('uid'));//取得用户uid
        $nickname = $this->user->get_nickname($uid);
        $file_name = md5($nickname)."_".$uid.'.jpg';

        $config['upload_path'] =  dirname(__FILE__)."/../../../static/uploads/";//上传目录
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

        $static_dir = dirname(__FILE__)."/../../../static";

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
     * 修改密码
     */
    public function password(){

        $uid = intval($this->input->cookie('uid'));//取得用户uid
        $user_info = $this->user->get_info_uid($uid);//取得用户信息

        $tpl_name = "art";

        $data = array();
        $data['title'] = "yuebee | 修改密码";
        $data['current_app'] = "password";//修改密码
        $data['current_block'] = "safe";//帐号安全
        $data['tpl_name'] = "art";//模板名

        $data['user_info'] = $user_info;

        $config = array(
            array(
                'field'   => 'current_pwd',
                'label'   => '当前密码',
                'rules'   => 'callback_current_pwd_check'
            ),
            array(
                'field'=> 'new_pwd',
                'label'=> '新密码',
                'rules'   => 'required|min_length[6]'
            ),
            array(
                'field'   => 'confirm_new_pwd',
                'label'   => '确认密码',
                'rules'   => 'required|matches[new_pwd]'
            )

        );

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules($config);

        if ( $this->form_validation->run() == false ){

            $this->load->view('users/tpl/'.$tpl_name.'/settings/common/settings_common_header',$data);
            $this->load->view('users/tpl/'.$tpl_name.'/settings/common/settings_common_left',$data);
            $this->load->view('users/tpl/'.$tpl_name.'/settings/settings_password_view',$data);
            $this->load->view('users/tpl/'.$tpl_name.'/settings/common/settings_common_footer',$data);


        }else{

            $password = $this->input->post('new_pwd');

            $this->user->update_pwd($uid,$password);

            $this->load->view('users/tpl/'.$tpl_name.'/settings/common/settings_common_header',$data);
            $this->load->view('users/tpl/'.$tpl_name.'/settings/common/settings_common_left',$data);
            $this->load->view('users/tpl/'.$tpl_name.'/settings/settings_password_success_view',$data);
            $this->load->view('users/tpl/'.$tpl_name.'/settings/common/settings_common_footer',$data);

        }

    }

    /*
     * 判断密码是否正确
     */
    public function current_pwd_check($current_pwd){

        if( $current_pwd == "" ){

            $this->form_validation->set_message('current_pwd_check', '%s不能为空');
            return FALSE;

        }else{

            $uid = intval($this->input->cookie('uid'));//取得用户uid
            $is_match = $this->user->is_match_uid($uid,$current_pwd);

            if( $is_match ){

                return TRUE;

            }else{

                $this->form_validation->set_message('current_pwd_check', '%s输入错误');
                return FALSE;

            }


        }


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


    /*
     * 检测昵称是否已存在
     */
    public function nickname_good($nickname){

        $uid = intval($this->input->cookie('uid'));//取得用户uid
        $current_nickname = $this->user->get_nickname($uid);

        if( $current_nickname == $nickname ){

            return TRUE;

        }

        return !$this->user->nickname_exist($nickname);

    }

    /*
     * 异步检测昵称是否存在
     */
    public function nickname_inst_check(){


        $nickname = $this->input->post('nickname');

        if( $this->nickname_good($nickname) ){

            echo "0";

        }else{

            echo "1";

        }

    }

    /*
     * 表单检测
     *
     * 昵称
     *
     */
    public function profile_nickname_check($nickname){

        $nickname = trim($nickname);
        $nickname_pn = "/^[0-9a-zA-Z\\x{4e00}-\\x{9fa5}_]*$/u";//昵称正则


        if( $nickname == "" ){

            $this->form_validation->set_message('profile_nickname_check', '请输入昵称');

            return FALSE;


        }else{

            $length = mb_strlen($nickname,'utf8');//取得实际位数，如 “我是lovelp" 为8位

            if( $length < 1 || $length > 16){

                $this->form_validation->set_message('profile_nickname_check', '昵称为1-16位的中英文、数字或_');

                return FALSE;

            }else{

                if( preg_match($nickname_pn,$nickname)){//区中英文、数字或_

                    return TRUE;

                }else{

                    $this->form_validation->set_message('profile_nickname_check', '昵称为1-16位的中英文、数字或_');

                    return TRUE;

                }


            }

        }

    }

}




/* End of file register.php */
/* Location: ./application/controllers/accounts/register.php */