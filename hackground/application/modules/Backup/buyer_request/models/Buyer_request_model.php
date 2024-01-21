<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buyer_request_model extends CI_Model{
	
	private $table , $primary_key;
	
	public function __construct(){
		$this->table = 'buyer_requests';
		$this->primary_key = 'request_id';
        return parent::__construct();
	}
	
	public function getList($srch=array(), $limit=0, $offset=20, $for_list=TRUE){
		$this->db->select('p.*,m.member_name')
			->from($this->table . ' p')
			->join('member m', 'm.member_id=p.seller_id', 'LEFT');
		
		if(!empty($srch['show']) && $srch['show'] == 'trash'){
			$this->db->where('p.request_status', REQUEST_DELETED);	
		}else{
			$this->db->where('p.request_status <>', REQUEST_DELETED);	
		}
		
		if(!empty($srch['term'])){
			$this->db->like('p.request_title', $srch['term']);
		}
		
		if(!empty($srch['status'])){
			$this->db->where('p.request_status', $srch['status']);
		}
		
		
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by($this->primary_key, 'DESC')->get()->result_array();
		}else{
			$result = $this->db->count_all_results();
		}
		
		return $result;
	}
	
	public function deleteRecord($id=''){
		if($id && is_array($id)){
			return $this->db->where_in($this->primary_key, $id)->update($this->table, array('request_status' => REQUEST_DELETED));
		}else{
			$ins['data'] = array('request_status' => REQUEST_DELETED);
			$ins['table'] = $this->table;
			$ins['where'] = array($this->primary_key => $id);
			return  update($ins);
		}
		
	}
	
	public function getDetail($id=''){
		$result = $this->db->where($this->primary_key, $id)->get($this->table)->row_array();
		return $result;
	}
	
}


