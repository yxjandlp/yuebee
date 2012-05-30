<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 5/7/12
 * Time: 4:48 PM
 *
 * 用户评论的操作
 *
 */

class User_comment_model extends CI_Model {

    private $tb_name;//表名

    public function __construct(){

        parent::__construct();

        $this->tb_name = $this->db->dbprefix('user_comment');//设置表名

    }


    /*
     * 添加评论
     */
    public function add_comment($feed_id,$author_id,$author_nickname,$comment){

        $feed_id = intval($feed_id);
        $author_id = intval($author_id);

        $sql = "INSERT INTO {$this->tb_name} (feed_id,author_id,author_nickname,comment,create_time) VALUES (?,?,?,?,?)";

        $this->db->query($sql,array($feed_id,$author_id,$author_nickname,$comment,time()));


    }

    /*
     * 获取评论
     */
    public function get_comments($feed_id){

        $feed_id = intval($feed_id);

        $sql = "SELECT * FROM {$this->tb_name} WHERE feed_id=?";

        $query = $this->db->query($sql,array($feed_id));

        return $query->result();


    }

    /*
     * 获取状态的回复数
     */
    public function get_reply_num($feed_id){

        $feed_id = intval($feed_id);

        $sql = "SELECT COUNT(*) AS num FROM {$this->tb_name} WHERE feed_id=?";

        $query = $this->db->query($sql,array($feed_id));

        return $query->row()->num;

    }

    /*
     * 获取第一条评论或最后一条评论
     *
     * 0代表第一条，1代表最后一条
     *
     */
    public function get_side_comment($feed_id,$type){

        $feed_id = intval($feed_id);

        if( $type == 0){

            $sql = "SELECT * FROM {$this->tb_name} WHERE feed_id=? LIMIT 0,1";

        }else{

            $sql = "SELECT * FROM {$this->tb_name} WHERE feed_id=? ORDER BY create_time DESC LIMIT 0,1";
        }


        $query = $this->db->query($sql,array($feed_id));

        if( $query->num_rows() > 0 ){

            return $query->row();

        }else{

            return false;

        }

    }


    /*
     * 获取指定数目的好友新鲜事
     */
    public function get_comment_limit($feed_id,$offset,$num){

        $feed_id = intval($feed_id);
        $offset = intval($offset);
        $num = intval($num);

        $sql = "SELECT * FROM {$this->tb_name} WHERE feed_id=? LIMIT ?,?";

        $query = $this->db->query($sql,array($feed_id,$offset,$num));

        return $query->result();

    }

}