<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 5/1/12
 * Time: 1:58 PM
 *
 * 找回密码的数据库操作
 *
 */

class Pwd_pending_model extends CI_Model {


    private $tb_name;//表名
    private $expiration_time;//过期时间

    public function __construct(){

        parent::__construct();
        $this->tb_name = $this->db->dbprefix('pwd_pending');
        $this->expiration_time = 60*30;//设置过期时间，这里是30分钟

    }

    /*
     * 插入一条待找回密码的pending
     */
    public function add_pending($email,$captcha){

        //$sql = sprintf("INSERT INTO %s (email,captcha) VALUES ('%s','%s')",$this->tb_name,$email,$captcha);
        $sql = "INSERT INTO {$this->tb_name} (email,captcha,create_time) VALUES (?,?,?)";
        $this->db->query($sql,array($email,$captcha,time()));

    }

    /*
     * 检验验证码是否有效
     */
    public function capthca_validate($email,$captcha){

        $this->del_pending();//先删除过期的pending信息

        //$sql = sprintf("SELECT captcha,UNIX_TIMESTAMP(create_time) create_time FROM %s WHERE email='%s'",$this->tb_name,$email);
        $sql = "SELECT captcha,create_time FROM {$this->tb_name} WHERE email=?";
        $query = $this->db->query($sql,array($email));

        if( $query->num_rows() > 0 ){

            foreach($query->result() as $row){

                $cr_captcha = $row->captcha;
                $create_time = $row->create_time;

                if( $captcha != $cr_captcha){//判断激活码是否相同

                    return false;

                }else{//判断时间是否过期

                    $cur_time = time();
                    $time = $create_time + $this->expiration_time;//计算该pending的过期点
                    if( $time < $cur_time ){

                        return false;

                    }else{//验证成功

                        return true;
                    }
                }
            }

        }else{

            return false;

        }

    }

    /*
     * 删除过期pending信息
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

/* End of file pwd_pending_model.php */
/* Location: ./application/models/pwd_pending_model.php */