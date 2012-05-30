<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 4/27/12
 * Time: 2:18 PM
 *
 * 处理注册请求
 *
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {

    public function __construct(){

        parent::__construct();

        $this->load->helper('form');//载入表单类
        $this->load->library('form_validation');//载入表单验证类
        $this->load->model('User_model','user');//载入User_model并重命名为user
        $this->load->model('User_pending_model',"pending");

    }

    /*
     * 显示注册界面
     */
    public function index(){

        $data = array();
        $data['title'] = 'yuebee ｜注册';

        $config = array(
            array(
                'field'   => 'email',
                'label'   => 'email',
                'rules'   => 'callback_email_check'
            ),
            array(
                'field'=> 'nickname',
                'label'=> '昵称',
                'rules'   => 'callback_nickname_check'
            ),
            array(
                'field'   => 'password',
                'label'   => '密码',
                'rules'   => 'required|min_length[6]'
            ),
            array(
                'field'   => 'password2',
                'label'   => '确认密码',
                'rules'   => 'required|matches[password]'
            ),
            array(
                'field'   => 'code',
                'label'   => '验证码',
                'rules'   => 'callback_code_check'
            )
        );

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules($config);

        if ( $this->form_validation->run() == false ){

            $this->load->view('common/header',$data);
            $this->load->view('accounts/register_view',$data);
            $this->load->view('common/footer',$data);

        }else{

            if( isset($_POST['token']) && $_POST['token'] == "submit_token" ){//判断是否第一次提交

                $email    = trim($this->input->post('email'));
                $nickname = trim($this->input->post('nickname'));
                $password = sha1($this->input->post('password'));//密码用sha1加密

                //$active_code = sha1(mt_rand(10000,99999).time().$email);//生成激活码
                $this->load->helper('string');
                $active_code = random_string('alnum', 15);//生成激活码

                unset($_POST['token']);//清除标记，防止重复提交



                /*----------------------------------------------------*\
                                      生成激活邮件
                \*----------------------------------------------------*/


                $uri_email = urlencode($email);//将email进行url包裹

                $active_url = site_url('accounts/register/confirm/' . $active_code.'/'. $uri_email);//激活链接

                $message = "欢迎注册约笔酷站，请点击以下链接激活您的帐号<br />";
                $message .= "<a href='".$active_url."'>".$active_url."</a><br />";
                $message .= "注：此链接将在提交注册后2小时失效,请及时激活帐号";//邮件内容


                $config['mailtype'] = "html";//发送html格式的内容

                $this->load->library('email');
                $this->email->initialize($config);

                $this->email->from('y810121687@126.com', 'yuebee.com | 约笔网');
                $this->email->to($email);//收件人
                $this->email->subject('激活您的约笔网帐号');
                $this->email->message($message);

                if(!$this->email->send()){//发送邮件

                    exit;
                }

                $uid = $this->user->add_user($email,$nickname,$password);//写入数据库,并返回uid
                $this->pending->add_pending($email,$active_code);

                $this->load->model('User_profile_model','profile');
                $this->profile->init_profile($uid);//初始化profile

            }//end if

            redirect('accounts/register/success');

        }

    }

    /*
     * email的验证规则
     */
    public function email_check($email){

        $email = trim($email);

        if( $email == ""){//如果邮箱地址为空

            $this->form_validation->set_message('email_check', '%s 不能为空');

            return false;

        } else{

            $this->load->helper('email');

            if( valid_email($email) ){//判断邮箱格式

                if( $this->user->email_exist($email) ){//判断邮箱是否已被注册

                    $this->form_validation->set_message('email_check', '该邮箱已被注册');

                    return false;

                }else {//该邮箱可以注册

                    return true;
                }

            } else{

                $this->form_validation->set_message('email_check', 'Email格不正确');

                return false;
            }

        }

    }


    /*
     * 昵称验证规则
     */
    public function nickname_check($nickname){

        $nickname = trim($nickname);
        $nickname_pn = "/^[0-9a-zA-Z\\x{4e00}-\\x{9fa5}_]*$/u";//昵称正则


        if( $nickname == "" ){

            $this->form_validation->set_message('nickname_check', '请输入昵称');

            return false;
        }else{

            $length = mb_strlen($nickname,'utf8');//取得实际位数，如 “我是lovelp" 为8位

            if( $length < 1 || $length > 16){

                $this->form_validation->set_message('nickname_check', '昵称为1-16位的中英文、数字或_');

                return false;

            }else{

                if( preg_match($nickname_pn,$nickname)){//区中英文、数字或_

                    return true;

                }else{

                    $this->form_validation->set_message('nickname_check', '昵称为1-16位的中英文、数字或_');

                    return false;

                }


            }

        }

    }


    /*
     * 验证验证码
     */
    public function code_check($code){

        $code = trim($code);

        if( $code == "" ){//验证码为空

            $this->form_validation->set_message('code_check', '请输入验证码');

            return false;

        } else{

            session_start();//开启session

            if( strtolower($code) != strtolower($_SESSION['captcha']) ){

                $this->form_validation->set_message('code_check', '验证码输入错误');

                return false;

            } else{//验证码输入正确

                return true;

            }
        }

    }

    /*
     * 异步验证注册信息
     */
    public function check(){

        $target = isset($_POST['target']) ? $_POST['target'] : "";

        switch( $target ){

            case 'email' ://检查邮箱地址

                $email = isset($_POST['email']) ? $_POST['email'] : "";

                if( $this->user->email_exist($email) ){

                    echo "1";//1代表邮箱已被注册已存在

                }else{

                    echo "0";//0代表邮箱可以使用
                }

                break;

            case 'captcha' ://检查验证码

                session_start();//开启session

                $captcha = isset($_POST['captcha']) ? $_POST['captcha'] : "";

                if( !isset($_SESSION['captcha']) ){

                    echo "2";//2代表验证码已过期

                }else {

                    if( strtolower($captcha) == strtolower($_SESSION['captcha']) ){

                        echo "0";//0代表验证码输入正确

                    }else{

                        echo "1";//1代表验证码输入错误

                    }
                }

                break;

            case 'nickname'://检查昵称

                $nickname = isset($_POST['nickname']) ? $_POST['nickname'] : "";

                if( $this->user->nickname_exist($nickname) ){

                    echo "1";//1代表昵称已被使用

                }else{

                    echo "0";//0代表昵称可以使用
                }

                break;

        }

    }

    /*
     * 添加用户进数据库并显示注册成功界面
     */
    public function success(){


        $data = array();
        $data['title'] = "yuebee | 注册成功";

        $this->load->view('common/header',$data);
        $this->load->view('accounts/register_success_view' ,$data);//显示成功界面
        $this->load->view('common/footer',$data);

    }

    /*
     * 激活账号
     */
    public function confirm($active_code,$email){

        $email = urldecode($email);//将邮箱地址进行反url解析

        if( $this->pending->user_activation($email,$active_code) ){//判断激活链接是否有效

            $actived = true;
            $this->pending->del_by_email($email);//删除该pending信息

        }else{

            $actived = false;
        }

        $data = array();
        $data['title'] = "yuebee | confirm";
        $data['actived'] = $actived;

        $this->load->view('common/header',$data);
        $this->load->view('accounts/confirm_view',$data);
        $this->load->view('common/footer',$data);
    }

}

/* End of file register.php */
/* Location: ./application/controllers/accounts/register.php */