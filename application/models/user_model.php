<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 4/28/12
 * Time: 9:37 AM
 *
 * User_model,对用户的一些数据库操作
 *
 */

class User_model extends CI_Model{

    private $tb_name;//用户表名
    private $avatar_path;

    public function __construct(){
        parent::__construct();

        $this->tb_name = $this->db->dbprefix('user');//设置表名
        $this->avatar_path = base_url('static/img/avatar/default.jpg');//默认头像地址

    }

    /*
     * 判断邮箱地址是否已被注册
     */
    public function email_exist($email){

        //$sql = sprintf("SELECT * FROM %s WHERE email = '%s'",$this->tb_name,$email);//设置查询语句
        $email = trim($email);
        $sql = "SELECT * FROM {$this->tb_name} WHERE email = ?";
        $query = $this->db->query($sql,array($email));

        return $query->num_rows() > 0;//大于零，即存在，返回true
    }

    /*
     * 判断昵称是否已被使用
     */
    public function nickname_exist($nickname){

        $nickname = trim($nickname);

        $sql = "SELECT * FROM {$this->tb_name} WHERE nickname=?";
        $query = $this->db->query($sql,array($nickname));

        return $query->num_rows() > 0;

    }

    /*
     * 添加用户
     */
    public function add_user($email,$nickname,$password){

        //$sql = sprintf("INSERT INTO %s (email,nickname,password) VALUES ('%s','%s','%s')",$this->tb_name,$email,$nickname,$password);
        $main_page = site_url('users/'.$nickname);

        $sql = "INSERT INTO {$this->tb_name} (email,nickname,password,avatar_path,main_page,join_time) VALUES (?,?,?,?,?,?)";

        $this->db->query($sql,array($email,$nickname,$password,$this->avatar_path,$main_page,time()));

        return $this->db->insert_id();//返回刚增加的用户的uid

    }

    /*
     * 激活用户
     */
    public function set_active($email){

        //$sql = sprintf("UPDATE %s SET is_active = 1 WHERE email='%s'",$this->tb_name,$email);
        $sql = "UPDATE {$this->tb_name} SET is_active = 1 WHERE email=?";
        $this->db->query($sql,array($email));
    }

    /*
     * 判断邮箱密码组合是否正确
     */
    public function is_match($email,$password){

        //$sql = sprintf("SELECT password FROM %s WHERE email='%s'",$this->tb_name,$email);
        $sql = "SELECT password FROM {$this->tb_name} WHERE email=?";
        $query = $this->db->query($sql,array($email));

        if( $query->num_rows() > 0 ){

            $row = $query->row();

            if( $row->password == sha1($password) ){//比较密码

                return true;

            }else{

                return false;
            }

        }else{

            return false;

        }

    }


    /*
     * 修改密码
     */
    public function update_pwd($email,$password){

        $email = trim($email);

        //$sql = sprintf("UPDATE %s SET password='%s' WHERE email='%s'",$this->tb_name,$password,$email);
        $sql = "UPDATE {$this->tb_name} SET password=? WHERE email=?";

        $this->db->query($sql,array($password,$email));


    }

    /*
    * 获得头像地址
    */
    public function get_avatar_path($uid){

        $uid=intval($uid);//转换为整型
        $sql = "SELECT avatar_path FROM {$this->tb_name} WHERE uid=?";
        $query = $this->db->query($sql,array($uid));

        if( $query->num_rows() > 0 ){

            $row = $query->row();
            return $row->avatar_path;

        }else{

            return false;

        }

    }


    /*
     * 根据email取得昵称
     */
    public function get_nickname($uid){

        $uid = intval($uid);

        $sql = "SELECT nickname FROM  {$this->tb_name}  WHERE uid=?";
        $query = $this->db->query($sql,array($uid));

        if( $query->num_rows() > 0 ){

            $row = $query->row();

            return $row->nickname;

        }else{

            return false;

        }

    }

    /*
     * 根据邮箱获得昵称
     */
    public function get_nickname_email($email){


        $sql = "SELECT nickname FROM  {$this->tb_name}  WHERE email=?";
        $query = $this->db->query($sql,array($email));

        if( $query->num_rows() > 0 ){

            $row = $query->row();

            return $row->nickname;

        }else{

            return false;

        }


    }

    /*
     * 根据email取得uid
     */
    public function get_uid_email($email){

        $email = trim($email);

        $sql = "SELECT uid FROM {$this->tb_name} WHERE email=?";
        $query = $this->db->query($sql,array($email));

        if( $query->num_rows() > 0 ){

            $row = $query->row();
            return $row->uid;

        }else{

            return false;

        }

    }

    /*
     * 根据昵称取得id
     */
    public function get_uid_nickname($nickname){

        $nickname = trim($nickname);

        $sql = "SELECT uid FROM {$this->tb_name} WHERE nickname=?";
        $query = $this->db->query($sql,array($nickname));

        if( $query->num_rows() > 0 ){

            $row = $query->row();
            return $row->uid;

        }else{

            return false;
        }



    }

    /*
     * 根据id取得用户email
     */
    public function get_email($uid){

        $uid = intval($uid);

        $sql = "SELECT email FROM {$this->tb_name} WHERE uid=?";
        $query = $this->db->query($sql,array($uid));

        if( $query->num_rows() > 0 ){

            $row = $query->row();
            return $row->email;

        }else{

            return false;
        }

    }

    /*
     * 获取用户的所有信息 by id
     */
    public function get_info_uid($uid){

        $uid = intval($uid);

        $sql = "SELECT * FROM {$this->tb_name} WHERE uid=?";
        $query = $this->db->query($sql,array($uid));

        if( $query->num_rows() > 0 ){

            return $query->row();

        }else{

            return false;

        }

    }

    /*
     * 获取用户的所有信息 by email
     */
    public function get_info_email($email){

        $email = trim($email);

        $sql = "SELECT * FROM {$this->tb_name} WHERE email=?";
        $query = $this->db->query($sql,array($email));

        if( $query->num_rows() > 0 ){

            return $query->row();

        }else{

            return false;

        }

    }

    /*
     * 获取用户的所有信息 by nickname
     */
    public function get_info_nickname($nickname){

        $nickname = trim($nickname);

        $sql = "SELECT * FROM {$this->tb_name} WHERE nickname=?";
        $query = $this->db->query($sql,array($nickname));

        if( $query->num_rows() > 0 ){

            return $query->row();

        }else{

            return false;

        }

    }

    /*
     * 头像是否修改
     */
    public function get_avatar_status($uid){

        $uid = intval($uid);

        $sql = "SELECT avatar_status FROM {$this->tb_name} WHERE uid=?";
        $query = $this->db->query($sql,array($uid));

        if( $query->num_rows() > 0 ){

            return $query->row()->avatar_status;

        }else{

            return false;

        }

    }

    /*
     * 修改用户的头像状态设为已自定义
     */
    public  function set_avatar_modified($uid){

        $uid = intval($uid);

        $sql = "UPDATE {$this->tb_name} SET avatar_status=? WHERE uid=?";

        $this->db->query($sql,array(1,$uid));

    }



}

/* End of file user_model.php */
/* Location: ./application/models/user_model.php */