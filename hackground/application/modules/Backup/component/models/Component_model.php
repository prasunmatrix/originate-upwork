<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Component_model extends CI_Model{
	
	private $table , $lang_table, $primary_key;
	
	public function __construct(){
        return parent::__construct();
	}
	
	
	public function configure($options=array()){
		$this->table = !empty($options['table']) ? $options['table'] : '';
		$this->lang_table =  !empty($options['lang_table']) ? $options['lang_table'] : '';
		$this->primary_key = !empty($options['primary_key']) ? $options['primary_key'] : '';
	}
	
	public function getList($srch=array(), $limit=0, $offset=20, $for_list=TRUE){
		$admin_default_lang = admin_default_lang();
		$this->db->select('*')
			->from($this->table. ' a')
			->join($this->lang_table. ' b', 'a.'.$this->primary_key.'='.'b.'.$this->primary_key);
		
		if(!empty($srch['show']) && $srch['show'] == 'trash'){
			$this->db->where('a.component_status', DELETE_STATUS);	
		}else{
			$this->db->where('a.component_status <>', DELETE_STATUS);	
		}
		
		if(!empty($srch['status'])){
			$this->db->where('a.component_status', $srch['status']);	
		}
		
		if(!empty($srch['term'])){
			$this->db->like('b.component_name', $srch['term']);
		}
		
		$this->db->where('b.component_lang', $admin_default_lang);	
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('a.component_order', 'ASC')->order_by('a.'.$this->primary_key, 'DESC')->get()->result_array();
		}else{
			$result = $this->db->count_all_results();
		}
		
		return $result;
	}
	
	public function addRecord($data=array()){
		$structure = array(
			'component_icon' => !empty($data['component_icon']) ? $data['component_icon'] : '',
			'component_icon_class' => !empty($data['component_icon_class']) ? $data['component_icon_class'] : '',
			'visible_in_detail' => !empty($data['visible_in_detail']) ? $data['visible_in_detail'] : '0',
			'component_key' => !empty($data['component_key']) ? $data['component_key'] : '',
			'component_type' => !empty($data['component_type']) ? $data['component_type'] : '',
			'component_order' => !empty($data['component_order']) ? $data['component_order'] : '',
			'description' => !empty($data['description']) ? $data['description'] : '',
			'component_status' => !empty($data['status']) ? $data['status'] : '0',
		);
		$ins['data'] = $structure;
		$ins['table'] = $this->table;
		$insert_id = insert($ins, TRUE);
		
		$lang_fields = $data['lang'];
		$this->insert_lang_data($lang_fields, $insert_id);
		
		
		return $insert_id;
	}
	
	
	public function insert_lang_data($lang_fields=array(), $insert_id=''){
		$all_lang = get_lang();
		
		$this->db->where($this->primary_key, $insert_id)->delete($this->lang_table);
		foreach($all_lang as $k => $v){
			
			
			$structure = array(
				$this->primary_key => $insert_id,
				'component_lang' => $v,
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
			'component_icon' => !empty($data['component_icon']) ? $data['component_icon'] : '',
			'component_icon_class' => !empty($data['component_icon_class']) ? $data['component_icon_class'] : '',
			'visible_in_detail' => !empty($data['visible_in_detail']) ? $data['visible_in_detail'] : '0',
			'component_key' => !empty($data['component_key']) ? $data['component_key'] : '',
			'component_type' => !empty($data['component_type']) ? $data['component_type'] : '',
			'component_order' => !empty($data['component_order']) ? $data['component_order'] : '',
			'description' => !empty($data['description']) ? $data['description'] : '',
			'component_status' => !empty($data['status']) ? $data['status'] : '0',
		);
		$ins['data'] = $structure;
		$ins['table'] = $this->table;
		$ins['where'] = array($this->primary_key => $id);
		
		
		$lang_fields = $data['lang'];
		$this->insert_lang_data($lang_fields, $id);
		
		
		return  update($ins);
	}
	
	public function deleteRecord($id=''){
		if($id && is_array($id)){
			return $this->db->where_in($this->primary_key, $id)->update($this->table, array('component_status' => DELETE_STATUS));
		}else{
			$ins['data'] = array('component_status' => DELETE_STATUS);
			$ins['table'] = $this->table;
			$ins['where'] = array($this->primary_key => $id);
			return  update($ins);
		}
		
	}
	
	public function getDetail($id=''){
		$result = $this->db->where($this->primary_key, $id)->get($this->table)->row_array();
		$lang_result = $this->db->where($this->primary_key, $id)->get($this->lang_table)->result_array();
		
		$lang_name=array();
		
		foreach($lang_result as $k => $v){
			$lang_name[$v['component_lang']] = $v['component_name'];
		}
		$result['lang'] = array();
		foreach($result as $k => $v){
			$result['lang']['component_name'] = $lang_name;
		}
		return $result;
	}
	
	public function getNameById($id=''){
		$admin_default_lang = admin_default_lang();
		$comp_row = get_row(
			array(
				'select' => '*',
				'from' => 'component_names',
				'where' => array('component_id' => $id, 'component_lang' => $admin_default_lang),
			)
		);
		
		if($comp_row['component_name']){
			return $comp_row['component_name'];
		}
		
		return false;
	}
	
	public function saveCategoryComponent($data=array()){
		$category_subchild_id = $data['category_subchild_id'];
		$child_level = $data['child_level'] ? $data['child_level'] : 0 ;
		$searchable_components = !empty($data['searchable_component_id']) ? $data['searchable_component_id'] : array();
		$required_components = !empty($data['required_component_id']) ? $data['required_component_id'] : array();
		$highlight_components = !empty($data['highlight_component_id']) ? $data['highlight_component_id'] : array();
		$rangefilter_components = !empty($data['rangefilter_component_id']) ? $data['rangefilter_component_id'] : array();
		$components = !empty($data['component_id']) ? $data['component_id'] : array();
		$component_order = !empty($data['component_order']) ? $data['component_order'] : array();
		$this->db->where('category_subchild_id', $category_subchild_id)->where('child_level',  $child_level)->delete('category_component');
		if($components){
			$ins = array();
			foreach($components as $k => $v){
				$ins[] = array(
					'category_subchild_id' => $category_subchild_id,
					'component_id' => $v,
					'is_searchable' => in_array($v, $searchable_components) ? 1 : 0,
					'is_required' => in_array($v, $required_components) ? 1 : 0,
					'is_highlight' => in_array($v, $highlight_components) ? 1 : 0,
					'is_rangefilter' => in_array($v, $rangefilter_components) ? 1 : 0,
					'status' => 1,
					'display_order' => !empty($component_order[$v]) ? $component_order[$v] : 0,
					'child_level' => $child_level,
				);
			}
			$this->db->insert_batch('category_component', $ins);
		}
		
		return TRUE;
	}
	
	public function getCategoryComponents($category_id='', $category_level=''){
		$this->db->select('c.*')
			->from('category_component c');
		
		$this->db->where('c.category_subchild_id', $category_id);
		$this->db->where('c.child_level', $category_level);
		$result = $this->db->get()->result_array();
		$return_data = array(
			'component' => array(),
			'searchable' => array(),
			'required' => array(),
			'highlight' => array(),
			'rangefilter' => array(),
			'display_order' => array(),
		);
		if($result){
			foreach($result as $k => $v){
				$return_data['component'][] = $v['component_id'];
				$return_data['display_order'][$v['component_id']] = $v['display_order'];
				if($v['is_searchable'] == 1){
					$return_data['searchable'][] =  $v['component_id'];
				}
				if($v['is_required'] == 1){
					$return_data['required'][] =  $v['component_id'];
				}
				if($v['is_highlight'] == 1){
					$return_data['highlight'][] =  $v['component_id'];
				}
				if($v['is_rangefilter'] == 1){
					$return_data['rangefilter'][] =  $v['component_id'];
				}
			}
		}
		
		return $return_data;

	}
	
	/* --------------------[ COMPONENT VALUE ]---------------------------------------------*/
	
	public function getComponentValues($srch=array(), $limit=0, $offset=20, $for_list=TRUE){
		$admin_default_lang = admin_default_lang();
		$this->db->select('*')
			->from('component_value a')
			->join('component_value_names b', 'a.component_value_id=b.component_value_id');
		
		if(!empty($srch['show']) && $srch['show'] == 'trash'){
			$this->db->where('a.component_value_status', DELETE_STATUS);	
		}else{
			$this->db->where('a.component_value_status <>', DELETE_STATUS);	
		}
		
		if(!empty($srch['component_id'])){
			$this->db->Where('a.component_id', $srch['component_id']);
		}
		
		if(!empty($srch['term'])){
			$this->db->like('b.component_value_name', $srch['term']);
		}
		
		$this->db->where('b.component_value_lang', $admin_default_lang);	
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('a.component_value_order', 'ASC')->order_by('a.component_value_id', 'DESC')->get()->result_array();
		}else{
			$result = $this->db->count_all_results();
		}
		
		return $result;
	}
	
	public function addComponentValues($data=array()){
		$structure = array(
			'component_value_key' => !empty($data['component_value_key']) ? $data['component_value_key'] : '',
			'component_id' => !empty($data['component_id']) ? $data['component_id'] : '',
			'component_value_order' => !empty($data['component_value_order']) ? $data['component_value_order'] : '',
			'component_value_status' => !empty($data['status']) ? $data['status'] : '0',
		);
		$ins['data'] = $structure;
		$ins['table'] = 'component_value';
		$insert_id = insert($ins, TRUE);
		
		$lang_fields = $data['lang'];
		$this->insertLangValues($lang_fields, $insert_id);
		
		
		return $insert_id;
	}
	
	public function updateComponentValues($data=array(), $id=''){
		$structure = array(
			'component_value_key' => !empty($data['component_value_key']) ? $data['component_value_key'] : '',
			/* 'component_id' => !empty($data['component_id']) ? $data['component_id'] : '', */
			'component_value_order' => !empty($data['component_value_order']) ? $data['component_value_order'] : '',
			'component_value_status' => !empty($data['status']) ? $data['status'] : '0',
		);
		$ins['data'] = $structure;
		$ins['table'] = 'component_value';
		$ins['where'] = array('component_value_id' => $id);
		
		
		$lang_fields = $data['lang'];
		$this->insertLangValues($lang_fields, $id);
		
		
		return  update($ins);
	}
	
	
	public function insertLangValues($lang_fields=array(), $insert_id=''){
		$all_lang = get_lang();
		
		$this->db->where('component_value_id', $insert_id)->delete('component_value_names');
		foreach($all_lang as $k => $v){
			
			
			$structure = array(
				'component_value_id' => $insert_id,
				'component_value_lang' => $v,
			);
			
			foreach($lang_fields as $field_name => $lang_val){
				$structure[$field_name] = $lang_fields[$field_name][$v];
			}
			
			$lang_record['data'] = $structure;
			$lang_record['table'] = 'component_value_names';
			
			insert($lang_record);
		}
	}
	
	public function getComponentValueById($id=''){
		$result = $this->db->where('component_value_id', $id)->get('component_value')->row_array();
		$lang_result = $this->db->where('component_value_id', $id)->get('component_value_names')->result_array();
		
		$lang_name=array();
		
		foreach($lang_result as $k => $v){
			$lang_name[$v['component_value_lang']] = $v['component_value_name'];
		}
		$result['lang'] = array();
		foreach($result as $k => $v){
			$result['lang']['component_value_name'] = $lang_name;
		}
		return $result;
	}
	
	public function deleteValues($id=''){
		$this->primary_key = 'component_value_id';
		$this->table = 'component_value';
		
		if($id && is_array($id)){
			return $this->db->where_in($this->primary_key, $id)->update($this->table, array('component_value_status' => DELETE_STATUS));
		}else{
			$ins['data'] = array('component_value_status' => DELETE_STATUS);
			$ins['table'] = $this->table;
			$ins['where'] = array($this->primary_key => $id);
			return  update($ins);
		}
	}
	
	
}


