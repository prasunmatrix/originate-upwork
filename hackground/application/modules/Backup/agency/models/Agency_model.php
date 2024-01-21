<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agency_model extends CI_Model{
	
	private $table , $lang_table, $primary_key;
	
	public function __construct(){
        return parent::__construct();
	}
	
	
	public function configure($options=array()){
		$this->table = !empty($options['table']) ? $options['table'] : '';
		$this->primary_key = !empty($options['primary_key']) ? $options['primary_key'] : '';
	}
	
	public function getList($srch=array(), $limit=0, $offset=20, $for_list=TRUE){
		$admin_default_lang = admin_default_lang();
		$this->db->select('*')
			->from($this->table. ' a');
		
		if(!empty($srch['show']) && $srch['show'] == 'trash'){
			$this->db->where('a.agent_status', DELETE_STATUS);	
		}else{
			$this->db->where('a.agent_status <>', DELETE_STATUS);	
		}
		
		if(!empty($srch['term'])){
			$this->db->group_start();
			$this->db->like('a.agent_name', $srch['term']);
			$this->db->or_where('a.agent_registration_number', $srch['term']);
			$this->db->or_where('a.agent_permit_number', $srch['term']);
			$this->db->or_where('a.ded_license_number', $srch['term']);
			$this->db->group_end();
		}
		
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('a.agent_id', 'DESC')->get()->result_array();
		}else{
			$result = $this->db->count_all_results();
		}
		
		return $result;
	}
	
	public function addRecord($data=array()){
		$structure = array(
			'agent_name' => !empty($data['agent_name']) ? $data['agent_name'] : '',
			'agent_logo' => !empty($data['agent_logo']) ? $data['agent_logo'] : '',
			'agent_registration_number' => !empty($data['agent_registration_number']) ? $data['agent_registration_number'] : '',
			'agent_permit_number' => !empty($data['agent_permit_number']) ? $data['agent_permit_number'] : '',
			'ded_license_number' => !empty($data['ded_license_number']) ? $data['ded_license_number'] : '',
			'agent_status' => !empty($data['status']) ? $data['status'] : '0',
			'agent_reg_date' => date('Y-m-d H:i:s'),
		);
		$ins['data'] = $structure;
		$ins['table'] = $this->table;
		$insert_id = insert($ins, TRUE);
		
		
		return $insert_id;
	}
	
	public function insert_lang_data($lang_fields=array(), $insert_id=''){
		$all_lang = get_lang();
		
		$this->db->where($this->primary_key, $insert_id)->delete($this->lang_table);
		foreach($all_lang as $k => $v){
			
			
			$structure = array(
				$this->primary_key => $insert_id,
				'country_lang' => $v,
			);
			
			foreach($lang_fields as $field_name => $lang_val){
				$structure[$field_name] = $lang_fields[$field_name][$v];
			}
			
			$lang_record['data'] = $structure;
			$lang_record['table'] = $this->lang_table;
			
			insert($lang_record);
		}
	}


	public function updateRecord($data=array(), $id=''){
		$structure = array(
			'agent_name' => !empty($data['agent_name']) ? $data['agent_name'] : '',
			'agent_logo' => !empty($data['agent_logo']) ? $data['agent_logo'] : '',
			'agent_registration_number' => !empty($data['agent_registration_number']) ? $data['agent_registration_number'] : '',
			'agent_permit_number' => !empty($data['agent_permit_number']) ? $data['agent_permit_number'] : '',
			'ded_license_number' => !empty($data['ded_license_number']) ? $data['ded_license_number'] : '',
			'agent_status' => !empty($data['status']) ? $data['status'] : '0',
		);
		$ins['data'] = $structure;
		$ins['table'] = $this->table;
		$ins['where'] = array($this->primary_key => $id);
		
		return  update($ins);
	}
	
	public function deleteRecord($id=''){
		if($id && is_array($id)){
			return $this->db->where_in($this->primary_key, $id)->update($this->table, array('country_status' => DELETE_STATUS));
		}else{
			$ins['data'] = array('country_status' => DELETE_STATUS);
			$ins['table'] = $this->table;
			$ins['where'] = array($this->primary_key => $id);
			return  update($ins);
		}
		
	}
	
	public function getDetail($id=''){
		$result = $this->db->where($this->primary_key, $id)->get($this->table)->row_array();
		
		return $result;
	}
	
	public function get_all_country(){
		$admin_default_lang = admin_default_lang();
		$this->db->select('*')
			->from('country a')
			->join('country_names b', 'a.country_code=b.country_code');
		
		$this->db->where('a.country_status', ACTIVE_STATUS);	
		
		$this->db->where('b.country_lang', $admin_default_lang);	
		$result = $this->db->order_by('b.country_name', 'ASC')->get()->result_array();
		return $result;
	}
	
	
}


