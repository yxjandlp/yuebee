<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 5/5/12
 * Time: 3:58 PM
 *
 * 对用户好友的一些操作
 *
 */

class User_friend_model extends CI_Model {

    private $tb_name;

    public function __construct(){

        parent::__construct();

        $this->tb_name = $this->db->dbprefix('user_friend');

    }

    /*
     * 添加好友
     */
    public function add_friend($uid,$fid,$fnickname){

        $uid = intval($uid);
        $fid = intval($fid);

        $sql = "INSERT INTO {$this->tb_name} (uid,fid,fnickname,groupid,accept_time) VALUES (?,?,?,?,?)";

        $this->db->query($sql,array($uid,$fid,$fnickname,0,time()));


    }

    /*
     * 获取好友列表
     */
    public function get_friends($uid){

        $uid = intval($uid);

        $sql = "SELECT * FROM {$this->tb_name} WHERE uid=?";

        $query = $this->db->query($sql,array($uid));

        return $query->result();

    }




}

/* End of file user_friend_model.php */
/* Location: ./application/models/user_friend_model.php */