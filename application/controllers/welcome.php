<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 4/27/12
 * Time: 2:00 PM
 *
 * 欢迎界面，即网站首页
 *
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
        $data = array();
        $data['title'] = "约笔";//传入的页面标题

        $this->load->view('common/header',$data);
		$this->load->view('welcome_view',$data);
        $this->load->view('common/footer',$data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */