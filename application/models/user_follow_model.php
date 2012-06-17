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

class User_follow_model extends CI_Model {

    private $tb_name;

    public function __construct(){

        parent::__construct();

        $this->tb_name = $this->db->dbprefix('user_follow');

    }

    /*
     * 某加关注
     */
    public function add_follow($uid,$fid,$unickname,$fnickname){

        $uid = intval($uid);
        $fid = intval($fid);

        $sql = "SELECT * FROM {$this->tb_name} WHERE uid=? AND fid=?";
        $query = $this->db->query($sql,array($fid,$uid));

        if( $query->num_rows() > 0 ){

            $follow_status = 1;//标为互相关注

        }else{

            $follow_status = 0;

        }

        $this->set_follow_status($fid,$uid,$follow_status);//更新另一方的关注状态为互相关注

        //$sql = "UPDATE {$this->tb_name} SET follow_status=? WHERE uid=? AND fid=?";
        //$this->db->query($sql,array(1,$fid,$uid));


        $sql = "INSERT INTO {$this->tb_name} (uid,fid,unickname,fnickname,follow_status,groupid,accept_time) VALUES (?,?,?,?,?,?,?)";

        $this->db->query($sql,array($uid,$fid,$unickname,$fnickname,$follow_status,0,time()));

        return $follow_status;


    }

    /*
     * 获取粉丝列表
     */
    public function get_fans($uid){

        $uid = intval($uid);

        $sql = "SELECT * FROM {$this->tb_name} WHERE fid=?";

        $query = $this->db->query($sql,array($uid));

        return $query->result();

    }

    /*
    * 获取关注列表
    */
    public function get_follow($uid){

        $uid = intval($uid);

        $sql = "SELECT * FROM {$this->tb_name} WHERE uid=?";

        $query = $this->db->query($sql,array($uid));

        return $query->result();

    }

    /*
     * 获取粉丝数量
     */
    public function get_fans_num($uid){

        $uid = intval($uid);

        $sql = "SELECT COUNT(*) as num FROM {$this->tb_name} WHERE fid=?";

        $query = $this->db->query($sql,array($uid));

        return $query->row()->num;


    }


    /*
     * 获得关注人数
     */
    public function get_follow_num($uid){

        $uid = intval($uid);

        $sql = "SELECT COUNT(*) as num FROM {$this->tb_name} WHERE uid=?";

        $query = $this->db->query($sql,array($uid));

        return $query->row()->num;


    }

    /*
     * 获得关注状态
     */
    public function get_follow_status($uid,$fid){

        $uid = intval($uid);
        $fid = intval($fid);

        $sql = "SELECT follow_status FROM {$this->tb_name} WHERE uid=? AND fid=?";

        $query = $this->db->query($sql,array($uid,$fid));

        if( $query->num_rows() > 0 ){

            return $query->row()->follow_status;

        }else{

            return -1;//表示未关注

        }

    }

    /*
     * 设置关注状态
     */
    public function set_follow_status($uid,$fid,$follow_status){

        $uid = intval($uid);
        $fid = intval($fid);
        $follow_status = intval($follow_status);

        $sql = "UPDATE {$this->tb_name} SET follow_status=? WHERE uid=? AND fid=?";

        $this->db->query($sql,array($follow_status,$uid,$fid));

    }

    /*
     * 取消关注
     */
    public function cancel_follow($uid,$fid){

        $uid = intval($uid);
        $fid = intval($fid);

        $this->set_follow_status($fid,$uid,0);//设置对方的关注状态

        $sql = "DELETE FROM {$this->tb_name} WHERE uid=? AND fid=?";
        $this->db->query($sql,array($uid,$fid));


    }




}

/* End of file user_friend_model.php */
/* Location: ./application/models/user_friend_model.php */