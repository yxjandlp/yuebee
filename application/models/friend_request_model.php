<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 5/4/12
 * Time: 4:27 PM
 *
 * 对添加好友请求的一些操作
 *
 */

class Friend_request_model extends CI_Model {

    private $tb_name;//表名

    public function __construct(){

        parent::__construct();

        $this->tb_name = $this->db->dbprefix('user_friend_request');

    }


    /*
     * 添加好友请求
     */
    public function add_request($to_uid,$from_uid,$from_nickname){

        $to_uid = intval($to_uid);
        $from_uid = intval($from_uid);

        $sql = "INSERT INTO {$this->tb_name} (to_uid,from_uid,from_nickname,request_time) VALUES (?,?,?,?)";

        $this->db->query($sql,array($to_uid,$from_uid,$from_nickname,time()));

    }

    /*
     * 获得好友请求的数目，如果没有返回false
     */
    public function get_request_num($uid){

        $uid = intval($uid);
        $sql = "SELECT COUNT(*) as num FROM {$this->tb_name} WHERE to_uid=?";

        $query = $this->db->query($sql,array($uid));

        return $query->row()->num;

    }


}

/* End of file friend_request_model.php */
/* Location: ./application/models/friend_request_model.php */