<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 4/29/12
 * Time: 1:18 AM
 *
 * 对待激活用户的一些数据库操作
 *
 */

class User_pending_model extends CI_Model{

    private $tb_name;//用户表名
    private $expiration_time;//过期时间

    public function __construct(){
        parent::__construct();

        $this->tb_name = $this->db->dbprefix('user_pending');//设置表名
        $this->expiration_time = 60*60*2;//设置过期时间，此处为2小时
    }

    /*
     * 添加待激活用户
     */
    public function add_pending($email,$active_code){

        //$sql = sprintf("INSERT INTO %s (email,active_code) VALUES ('%s','%s')",$this->tb_name,$email,$active_code);
        $sql = "INSERT INTO {$this->tb_name} (email,active_code,create_time) VALUES (?,?,?)";
        $this->db->query($sql,array($email,$active_code,time()));

    }

    /*
     * 激活用户
     */
    public function user_activation($email,$active_code){

        $this->del_pending();//先删除过期的pending信息

        //$sql = sprintf("SELECT active_code,UNIX_TIMESTAMP(create_time) create_time FROM %s WHERE email='%s'",$this->tb_name,$email);
        $sql = "SELECT active_code,create_time FROM {$this->tb_name} WHERE email=?";
        $query = $this->db->query($sql,array($email));

        if( $query->num_rows() > 0 ){

            foreach($query->result() as $row){

                $cr_active_code = $row->active_code;
                $create_time = $row->create_time;

                if( $active_code != $cr_active_code){//判断激活码是否相同

                    return false;

                }else{//判断时间是否过期

                    $cur_time = time();
                    $time = $create_time + $this->expiration_time;//计算该pending的过期点
                    if( $time < $cur_time ){

                        return false;

                    }else{//激活用户

                        $this->load->model('User_model','user');
                        $this->user->set_active($email);

                        return true;
                    }
                }
            }

        }else{

            return false;

        }
    }

    /*
     * 删除过期用户pending信息
     */
    public function del_pending(){

        $del_time = time() - $this->expiration_time;//设定删除的时间点,此时间点以前的信息将被删除

        //$sql = sprintf("DELETE FROM %s WHERE UNIX_TIMESTAMP(create_time) < %d",$this->tb_name,$del_time);
        $sql = "DELETE FROM {$this->tb_name} WHERE create_time < ?";

        $this->db->query($sql,array($del_time));
    }

    /*
     * 删除指定email的pending信息
     */
    public function del_by_email($email){

        //$sql = sprintf("DELETE FROM %s WHERE email='%s'",$this->tb_name,$email);
        $sql = "DELETE FROM {$this->tb_name} WHERE email=?";
        $this->db->query($sql,array($email));

    }

}

/* End of file user_model.php */
/* Location: ./application/models/user_model.php */