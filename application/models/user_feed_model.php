<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 5/6/12
 * Time: 1:01 PM
 *
 * 对用户status的一些操作
 *
 */


class User_feed_model extends CI_Model {


    private $tb_name;
    private $friend_tb_name;

    public function __construct(){

        parent::__construct();

        $this->tb_name = $this->db->dbprefix('user_feed');
        $this->friend_tb_name = $this->db->dbprefix('user_friend');

    }


    /*
     * 添加一条状态
     */
    public function add_feed($uid,$nickname,$meessage,$type){

        $uid = intval($uid);
        $type = intval($type);
        $sql = "INSERT INTO {$this->tb_name} (uid,nickname,message,feed_type,create_time) VALUES (?,?,?,?,?)";

        $this->db->query($sql,array($uid,$nickname,$meessage,$type,time()));

    }

    /*
     * 获取指定用户的状态
     */
    public function get_feed($uid,$type){

        $uid = intval($uid);
        $type = intval($type);

        $sql = "SELECT * FROM {$this->tb_name} WHERE uid=? AND feed_type=? ORDER BY create_time DESC ";

        $query = $this->db->query($sql,array($uid,$type));

        return $query->result();

    }

    /*
     * 获取好友的状态列表
     */
    public function get_friend_feed($uid){

        $uid = intval($uid);

        $sql = "SELECT * FROM {$this->tb_name} WHERE uid= ? OR uid= ANY (SELECT fid FROM {$this->friend_tb_name} WHERE uid=?) ORDER BY create_time DESC";

        $query = $this->db->query($sql,array($uid,$uid));

        return $query->result();


    }

    /*
     * 获取指定数目的好友新鲜事
     */
    public function get_friend_feed_limit($uid,$offset,$num){

        $uid = intval($uid);
        $offset = intval($offset);
        $num = intval($num);

        $sql = "SELECT * FROM {$this->tb_name} WHERE uid= ? OR uid= ANY (SELECT fid FROM {$this->friend_tb_name} WHERE uid=?) ORDER BY create_time DESC  LIMIT ?,?";

        $query = $this->db->query($sql,array($uid,$uid,$offset,$num));

        return $query->result();
    }

    /*
     * 更新状态的回复数
     */
    public function update_reply_num($feed_id,$total_reply){

        $feed_id = intval($feed_id);
        $total_reply = intval($total_reply);

        $sql = "UPDATE {$this->tb_name} SET reply_num=? WHERE fid=?";

        $this->db->query($sql,array($total_reply,$feed_id));

    }

    /*
     * 获取状态的发表者
     */
    public function get_author_id($feed_id){

        $feed_id = intval($feed_id);
        $sql = "SELECT uid FROM {$this->tb_name} WHERE fid=?";

        $query = $this->db->query($sql,array($feed_id));

        if( $query->num_rows() > 0 ){

            return $query->row()->uid;

        }else{

            return false;

        }


    }


    /*
     *
     * 获取指id的状态信息
     *
     * 为了使user_status_view的脚本改变最少，
     * 这里返回了一个结果集，而不是单条结果
     *
     */
    public function get_feeds_fid($feed_id){

        $feed_id = intval($feed_id);
        $sql = "SELECT * FROM {$this->tb_name} WHERE fid=?";

        $query = $this->db->query($sql,array($feed_id));

        return $query->result();

    }

    /*
     * 获取提定id的状态信息
     */
    public function get_feed_by_fid($feed_id){

        $feed_id = intval($feed_id);
        $sql = "SELECT * FROM {$this->tb_name} WHERE fid=?";

        $query = $this->db->query($sql,array($feed_id));

        if( $query->num_rows() > 0 ){

            return $query->row();

        }else{

            return false;

        }

    }

    /*
     * 获得回复总数
     */
    public function get_reply_num($feed_id){

        $feed_id = intval($feed_id);

        $sql = "SELECT reply_num FROM {$this->tb_name} WHERE fid=?";
        $query = $this->db->query($sql,array($feed_id));

        if( $query->num_rows() > 0 ){

            return $query->row()->reply_num;

        }else{

            return false;

        }



    }



}



/* End of file user_model.php */
/* Location: ./application/models/user_model.php */