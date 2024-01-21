<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_landloard_model extends CI_Model{
	
	private $table , $primary_key;
	
	public function __construct(){
		$this->table = 'member_landlord';
		$this->primary_key = 'landlord_id';
        return parent::__construct();
	}
	
	public function getList($srch=array(), $limit=0, $offset=20, $for_list=TRUE){
		$this->db->select('m_l.*,m.member_name')
			->from($this->table.' m_l')
			->join('member m', 'm.member_id=m_l.member_id', 'LEFT');
		
		if(!empty($srch['show']) && $srch['show'] == 'trash'){
			$this->db->where('landlord_status', DELETE_STATUS);	
		}else{
			$this->db->where('landlord_status <>', DELETE_STATUS);	
		}
		
		if(!empty($srch['term'])){
			$this->db->like('landlord_name', $srch['term']);
		}
		
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by($this->primary_key, 'DESC')->get()->result_array();
		}else{
			$result = $this->db->count_all_results();
		}
		
		return $result;
	}
	
	public function addRecord($data=array()){
		$structure = array(
			'landlord_name' => !empty($data['landlord_name']) ? $data['landlord_name'] : '',
			'deed_number' => !empty($data['deed_number']) ? $data['deed_number'] : '',
			'pre_registration_no' => !empty($data['pre_registration_no']) ? $data['pre_registration_no'] : '',
			'reg_date' => date('Y-m-d H:i:s'),
			'landlord_status' => !empty($data['status']) ? $data['status'] : '0',
		);
		$ins['data'] = $structure;
		$ins['table'] = $this->table;
		$insert_id = insert($ins, TRUE);
		return $insert_id;
	}

	public function updateRecord($data=array(), $id=''){
		$structure = array(
			'landlord_name' => !empty($data['landlord_name']) ? $data['landlord_name'] : '',
			'deed_number' => !empty($data['deed_number']) ? $data['deed_number'] : '',
			'pre_registration_no' => !empty($data['pre_registration_no']) ? $data['pre_registration_no'] : '',
			'landlord_status' => !empty($data['status']) ? $data['status'] : '0',
		);
		$ins['data'] = $structure;
		$ins['table'] = $this->table;
		$ins['where'] = array($this->primary_key => $id);
		return  update($ins);
	}
	
	public function deleteRecord($id=''){
		if($id && is_array($id)){
			return $this->db->where_in($this->primary_key, $id)->update($this->table, array('landlord_status' => DELETE_STATUS));
		}else{
			$ins['data'] = array('landlord_status' => DELETE_STATUS);
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


