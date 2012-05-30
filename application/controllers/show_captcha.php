<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 4/28/12
 * Time: 12:25 PM
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Show_captcha extends CI_Controller{

    public function index(){
        $this->load->helper('captcha');
        $vals = array(//验证码图片属性
            'img_width' => 150,
            'img_height' => 30
        );

        $cap = create_captcha($vals);//生成验证码

    }
}