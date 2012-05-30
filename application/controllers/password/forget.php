<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 4/29/12
 * Time: 10:52 PM
 *
 * 对密码进行一些操作
 *
 */

class Forget extends CI_Controller {

    public function __construct(){

        parent::__construct();

        $this->load->model('Pwd_pending_model','pwd_pending');//载入Pwd_pending_model,以进行验证码的操作
    }

    public function index(){

        redirect(site_url('password/forget/step_1'));//转到第一步

    }

    public function change(){

    }

    /*
     * 第一步
     */
    public function step_1(){

        $data = array();
        $data['title'] = "yuebee | 忘记密码";

        $config = array(//表单验证规则
            array(
                'field'   => 'pwd_email',
                'label'   => 'email',
                'rules'   => 'callback_email_check'
            )
        );

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules($config);

        if( $this->form_validation->run() == false ){//表单是否正确

            $this->load->view('common/header',$data);
            $this->load->view('password/step_1_view',$data);
            $this->load->view('common/footer',$data);

        }else {


            $email = trim($this->input->post('pwd_email'));//取得邮箱地址

            setcookie("safe_email",$email);//设置cookie,是进行和二步的保证
            setcookie('email_check',"true");

            $this->load->helper('string');
            $captcha = random_string('nozero', 6);//生成验证码


            /*-----------------将验证码写入数据库--------------------*/

            $this->pwd_pending->del_by_email($email);//先删除之前存在的pending,保证验证码唯一
            $this->pwd_pending->add_pending($email,$captcha);//添加该pending


            /*----------------------------------------------------*\
                                  生成验证邮件
            \*----------------------------------------------------*/


            $message  = "约笔酷站<br />";
            $message .= "您本次的验证码为:";
            $message .= "<h2>$captcha</h2>";
            $message .= "本验证码将在30分钟后失效，且只能使用一次，请及时验证";//邮箱内容

            $config['mailtype'] = "html";//发送html格式的内容

            $this->load->library('email');
            $this->email->initialize($config);

            $this->email->from('y810121687@126.com', 'yuebee.com | 约笔网');
            $this->email->to($email);//收件人
            $this->email->subject('约笔网 － 找回密码');
            $this->email->message($message);

            if(!$this->email->send()){//发送邮件

                exit;
            }
            redirect('password/forget/step_2');

        }



    }

    /*
     * 第二步
     */
    public function step_2(){

        if( $this->input->cookie('email_check') == FALSE ){//判断邮箱是否经过第一步的验证

            redirect('password/forget/step_1');//转到第一步

        }

        $data = array();
        $data['title'] = "yuebee | 忘记密码";

        $config = array(//表单验证规则
            array(
                'field'   => 'pwd_captcha',
                'label'   => '验证码',
                'rules'   => 'callback_captcha_check'
            )
        );

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules($config);//设置规则

        if( $this->form_validation->run() == false ){//表单是否正确

            $this->load->view('common/header',$data);
            $this->load->view('password/step_2_view',$data);
            $this->load->view('common/footer',$data);

        }else {

            setcookie('email_check',"",time() - 3600);//删除cookie,确保只有一次验证机会
            setcookie('captcha_check','true');
            redirect('password/forget/step_3');
        }

    }

    /*
     * 第三步
     */
    public function step_3(){

        if( $this->input->cookie('captcha_check',TRUE) == FALSE ){//通过cookie值判断是否已验证注册邮箱

            redirect('password/forget/step_1');//转到第一步
        }

        $data = array();
        $data['title'] = "yuebee | 忘记密码";


        $config = array(//表单验证规则
            array(
                'field'   => 'password',
                'label'   => '密码',
                'rules'   => 'required|min_length[6]'
            ),
            array(
                'field'   => 'password2',
                'label'   => '确认密码',
                'rules'   => 'required|matches[password]'
            )
        );

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules($config);//设置规则
        $this->form_validation->set_message('matches', '两次输入的密码不一致');

        if( $this->form_validation->run() == false ){//表单是否正确

            $this->load->view('common/header',$data);
            $this->load->view('password/step_3_view',$data);
            $this->load->view('common/footer',$data);

        }else {

            $email = $this->input->cookie('safe_email');//取得需要更改的帐记
            $password = sha1($this->input->post('password'));//加密码后的密码

            $this->load->model('User_model',"user");
            $this->user->update_pwd($email,$password);//设置新密码

            setcookie("captcha_check", "", time() - 3600);//删除cookie,确保只有一次修改密码的机会
            redirect('password/forget/success');

        }



    }

    public function email_check($email){

        $email = trim($email);

        if( $email == ""){//如果邮箱地址为空

            $this->form_validation->set_message('email_check', '%s 不能为空');

            return false;

        } else{

            $this->load->helper('email');

            if( valid_email($email) ){//判断邮箱格式

                $this->load->model('User_model','user');
                if( $this->user->email_exist($email) ){//判断邮箱是否注册

                    return true;

                }else {//未注册

                    $this->form_validation->set_message('email_check', '该邮箱未注册');
                    return false;

                }

            } else{

                $this->form_validation->set_message('email_check', 'Email格不正确');

                return false;
            }

        }
    }

    /*
     * 检查验证码的有效性
     */
    public function captcha_check($captcha){

        $captcha = trim($captcha);
        $email = $this->input->cookie('safe_email');

        if( $captcha == "" ){//验证码为空

            $this->form_validation->set_message('captcha_check', '请输入验证码');

            return false;

        } else{

            if( $this->pwd_pending->capthca_validate($email,$captcha) ){//验证码输入正确

                $this->pwd_pending->del_by_email($email);//验证完后删除该pending，即只能验证一次
                return true;

            }else{

                $this->form_validation->set_message('captcha_check', '验证码输入错误或已验证过一次');
                return false;

            }
        }

    }
    
    public function success(){
        
        $data = array();
        $data['title'] = "yuebee | 找回密码成功";

        $this->load->view('common/header',$data);
        $this->load->view('password/find_success_view',$data);
        $this->load->view('common/footer',$data);
        
    }

}

/* End of file forget.php */
/* Location: ./application/controllers/password/forget.php *
