<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Language_preference_model extends CI_Model{
	
	private $table , $primary_key;
	
	public function __construct(){
		$this->table = 'language_preference';
		$this->primary_key = $this->table.'_id';
        return parent::__construct();
	}
	
	public function getList($srch=array(), $limit=0, $offset=20, $for_list=TRUE){
		$this->db->select('*')
			->from($this->table);
		
		if(!empty($srch['show']) && $srch['show'] == 'trash'){
			$this->db->where('language_preference_status', DELETE_STATUS);	
		}else{
			$this->db->where('language_preference_status <>', DELETE_STATUS);	
		}
		
		if(!empty($srch['term'])){
			$this->db->like('language_preference_name', $srch['term']);
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
			'language_preference_name' => !empty($data['language_preference_name']) ? $data['language_preference_name'] : '',
			'language_preference_info' => !empty($data['language_preference_info']) ? $data['language_preference_info'] : '',
			'language_preference_ord' => !empty($data['language_preference_ord']) ? $data['language_preference_ord'] : '0',
			'language_preference_status' => !empty($data['status']) ? $data['status'] : '0',
		);
		$ins['data'] = $structure;
		$ins['table'] = $this->table;
		$insert_id = insert($ins, TRUE);
		return $insert_id;
	}

	public function updateRecord($data=array(), $id=''){
		$structure = array(
			'language_preference_name' => !empty($data['language_preference_name']) ? $data['language_preference_name'] : '',
			'language_preference_info' => !empty($data['language_preference_info']) ? $data['language_preference_info'] : '',
			'language_preference_ord' => !empty($data['language_preference_ord']) ? $data['language_preference_ord'] : '0',
			'language_preference_status' => !empty($data['status']) ? $data['status'] : '0',
		);
		$ins['data'] = $structure;
		$ins['table'] = $this->table;
		$ins['where'] = array($this->primary_key => $id);
		return  update($ins);
	}
	
	public function deleteRecord($id=''){
		if($id && is_array($id)){
			return $this->db->where_in($this->primary_key, $id)->update($this->table, array('language_preference_status' => DELETE_STATUS));
		}else{
			$ins['data'] = array('language_preference_status' => DELETE_STATUS);
			$ins['table'] = $this->table;
			$ins['where'] = array($this->primary_key => $id);
			return  update($ins);
		}
		
	}
	
	public function getDetail($id=''){
		$result = $this->db->where($this->primary_key, $id)->get($this->table)->row_array();
		return $result;
	}
	
	public function getAllLanguagePreference(){
		$all_lang_count = $this->getList('', '', '', FALSE);
		$result = $this->getList('', 0, $all_lang_count);
		return $result;
	}
	
}


