<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 5/3/12
 * Time: 1:39 PM
 *
 * 对用户资料的一些操作
 *
 */

class User_profile_model extends CI_Model {

    private $tb_name;//表名


    public function __construct(){
        parent::__construct();

        $this->tb_name = $this->db->dbprefix('user_profile');

    }


    /*
     * 初始化profile
     */
    public function init_profile($uid){

        $uid = intval($uid);//转换为整型
        $sql = "INSERT INTO {$this->tb_name} (uid) VALUES (?)";
        $this->db->query($sql,array($uid));

    }



    /*
     * 获取用户的profile by id
     */
    public function get_profile_id($uid){


        $uid = intval($uid);

        $sql = "SELECT * FROM {$this->tb_name} WHERE uid=?";
        $query = $this->db->query($sql,array($uid));

        if( $query->num_rows() > 0 ){

            $row = $query->row();
            return $row;

        }
        else{

            return false;

        }


    }


}

/* End of file user_profile_model.php */
/* Location: ./application/models/user_profile_model.php */