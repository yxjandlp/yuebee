<?php
/**
 * Created by yuebee.
 * User: lovelp
 * Date: 5/15/12
 * Time: 3:56 PM
 *
 * 省市的查询
 *
 */

class Common_district_model extends CI_Model{


    private $tb_name;

    public function __construct(){

        parent::__construct();

        $this->tb_name = $this->db->dbprefix('common_district');

    }

    /*
     * 获取省份列表
     */
    public function get_province(){

        $sql = "SELECT * FROM {$this->tb_name} WHERE level=?";

        $query = $this->db->query($sql,array(1));

        return $query->result();


    }

    /*
     * 获取城市列表
     */
    public function get_city($province_id){

        $province_id = intval($province_id);

        $sql = "SELECT * FROM {$this->tb_name} WHERE upid = ?";

        $query = $this->db->query($sql,array($province_id));

        return $query->result();

    }


}



/* End of file common_district_model.php */
/* Location: ./application/models/common_district_model.php */