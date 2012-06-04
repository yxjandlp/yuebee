<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 4/27/12
 * Time: 2:10 PM
 *
 * 处理登录请求
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    private $referer_url;//点击登录前的页面
    private $expiration;//保持登录的时间,0代表浏览器关闭则退出

    public function __construct(){

        parent::__construct();

        $this->referer_url = site_url('');
        $this->expiration = 0;

    }

    public function index(){

        $data = array();

        $data['title'] = "yuebee | 登录";
        $data['pwd_url'] = site_url('password/forget/step_1');//找回密码的链接地址

        $data['error_msg'] = "";
        $data['error_class'] = "hide";
        $data['email'] = "";
        $data['password'] = "";


        //验证提交表单
        if( $_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['login']) ){//是否提交

            $this->load->model("User_model","user");

            $email = $this->input->post('login_email');
            $password = $this->input->post('login_pwd');
            $nickname = $this->user->get_nickname_email($email);//昵称
            $id = $this->user->get_uid_email($email);

            $this->referer_url = isset($_POST['referer_url']) ? $_POST['referer_url'] : site_url('');

            if( $this->user->is_match($email,$password) ){//邮箱和密码是否匹配

                $config_id = array(

                    'name'  => 'uid',
                    'value' => $id,
                    'expire'=> $this->expiration

                );

                $config_nickname = array(

                    'name'  => 'nickname',
                    'value' => $nickname,
                    'expire'=> $this->expiration

                );

                $this->input->set_cookie($config_id);
                $this->input->set_cookie($config_nickname);

                redirect(site_url('accounts/login/success'));//转入登录成功页面

            }else{

                $data['email'] = $email;
                $data['password'] = $password;//重填邮箱和密码

                $data['error_msg'] = "用户名或密码输入错误";
                $data['error_class'] = "";

            }
        }

        $this->load->view('common/header',$data);
        $this->load->view('accounts/login_view',$data);
        $this->load->view('common/footer',$data);
    }


    /*
     * 登录成功
     */
    public function success(){

        $data = array();
        $data['title'] = "yuebee | 登录成功";
        $data['referer_url'] = $this->referer_url;

        $this->load->view('common/header',$data);
        $this->load->view('accounts/login_success_view',$data);
        $this->load->view('common/footer',$data);


    }

    /*
     * 注销登录
     */
    public function logout(){

        $config = array(

            'name'  => 'uid',
            'value' => '',
            'expire'=> ''//expire置空

        );
        $this->input->set_cookie($config);//将expire设置为空，删除除cookie

        redirect(site_url('/'));

    }

}

/* End of file login.php */
/* Location: ./application/controllers/accounts/login.php */
