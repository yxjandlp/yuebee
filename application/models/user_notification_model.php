<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 5/4/12
 * Time: 11:51 PM
 *
 * 对消息提醒的一些数据库操作
 *
 */

class User_notification_model extends CI_Model {


    private $tb_name;//表名

    public function __construct(){

        parent::__construct();

        $this->tb_name = $this->db->dbprefix('user_notification');

    }


    /*
     * 添加一条提醒消息
     */
    public function add_notification($to_uid,$from_uid,$from_nickname,$type,$note,$from_id = 0){

        $to_uid = intval($to_uid);
        $from_uid = intval($from_uid);
        $type = intval($type);
        $from_id = intval($from_id);

        if( $to_uid == $from_uid) return;//如果评论者是作得本人，则跳过


        $sql = "INSERT INTO {$this->tb_name} (to_uid,from_uid,from_nickname,type,note,create_time,from_id) VALUES (?,?,?,?,?,?,?)";

        $this->db->query($sql,array($to_uid,$from_uid,$from_nickname,$type,$note,time(),$from_id));

    }


    /*
     * 统计所有指定用户的消息条数
     */
    public function get_notification_num($to_uid,$checked){

        $to_uid = intval($to_uid);
        $checked = intval($checked);

        $sql = "SELECT COUNT(*) as num FROM {$this->tb_name} WHERE to_uid=? AND checked=?";

        $query = $this->db->query($sql,array($to_uid,$checked));

        return $query->row()->num;

    }

    /*
     * 返回指定类型信息的条数
     */
    public function get_num_by_type($to_uid,$checked,$type){

        $to_uid = intval($to_uid);
        $type = intval($type);
        $checked = intval($checked);

        $sql = "SELECT COUNT(*) as num FROM {$this->tb_name} WHERE to_uid=? AND checked=? AND type=?";

        $query = $this->db->query($sql,array($to_uid,$checked,$type));

        return $query->row()->num;

    }


    /*
     * 取得指定类型的消息
     */
    public function get_notifications($to_uid,$type,$checked){

        $to_uid = intval($to_uid);
        $type = intval($type);
        $checked = intval($checked);//是否已读

        $sql = "SELECT * FROM {$this->tb_name} WHERE to_uid=? AND type=? AND checked=?";

        $query = $this->db->query($sql,array($to_uid,$type,$checked));

        return $query->result();



    }

    /*
     * 取得指定id的消息
     */
    public function get_notification_id($id){

        $id = intval($id);

        $sql = "SELECT * FROM {$this->tb_name} WHERE id=?";
        $query = $this->db->query($sql,array($id));

        if( $query->num_rows() > 0 ){

            $row = $query->row();
            return $row;

        }else{

            return false;

        }

    }

    /*
     * 设置消息为已处理
     */
    public function set_checked($id){

        $id = intval($id);
        $sql = "UPDATE {$this->tb_name} SET checked=? WHERE id=?";

        $this->db->query($sql,array(1,$id));


    }

    /*
     * 把指定用户的指定类型的消息设为已读
     */
    public function set_checked_type($uid,$type){

        $uid = intval($uid);
        $type = intval($type);

        $sql = "UPDATE {$this->tb_name} SET checked=? WHERE to_uid=? AND type=?";

        $this->db->query($sql,array(1,$uid,$type));


    }
}


/* End of file user_notification_model.php */
/* Location: ./application/models/user_notification_model.php */